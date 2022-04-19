<?php

namespace App\Http\Livewire;

use App\Models\Barang;
use App\Models\Permintaan;
use App\Models\Puskesmas;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PermintaanComponent extends Component
{
    public $barang_id, $puskesmas_id, $jumlah, $keterangan;
    public $idTerpilih, $idDelete;
    public $options = 'Tambah';
    public $barangs, $puskesmass;
    public function mount()
    {
        $this->barangs = Barang::select(['id', 'nama_barang'])->get();
        $this->puskesmass = Puskesmas::all();

        if (Auth::user()->level == 'user') {
            Permintaan::where('terbaca_user', null)->where('user_id', Auth::user()->id)->update(['terbaca_user' => 'y']);
        }
    }
    public function render()
    {
        if (Auth::user()->level == 'admin') {
            $data = Permintaan::with(['user', 'barang', 'puskesmas'])->paginate(10);
        } else {
            $data = Permintaan::with(['user', 'barang', 'puskesmas'])->where('user_id', Auth::user()->id)->paginate(10);
        }
        return view('livewire.permintaan-component', ['lists' => $data])->extends('layouts.app')->section('content');
    }

    public function resetInput()
    {
        $this->reset(['barang_id', 'puskesmas_id', 'jumlah', 'keterangan', 'idTerpilih', 'idDelete', 'options']);
    }

    public function store()
    {
        $data = $this->validate(
            [
                'barang_id' => 'required',
                'puskesmas_id' => 'required',
                'jumlah' => 'required|numeric',
            ],
            [
                'barang_id.required' => 'Harap di pilih',
                'puskesmas_id.required' => 'Harap di pilih',
                'jumlah.required' => 'Harap di isi',
                'jumlah.numeric' => 'inputan hanya bisa angka',
            ],
        );
        $data['keterangan'] = $this->keterangan;
        $data['user_id'] = Auth::id();
        Permintaan::updateOrCreate(['id' => $this->idTerpilih], $data);
        session()->flash('message', $this->idTerpilih ? 'Permintaan berhasil di rubah' : 'Permintaan berhasil di buat');
        $this->resetInput();
        $this->dispatchBrowserEvent('toast-success');
    }

    public function terima($id)
    {
        $data = Permintaan::find($id);
        $data->status = 'terima';
        $barang = Barang::find($data->barang_id);

        if ($barang->stok_akhir < $data->jumlah) {
            $this->dispatchBrowserEvent('edit-fail');
        } else {
            $barang->stok_akhir -= $data->jumlah;
            $barang->save();
            $data->terbaca_pengurus = 'y';
            $data->save();
        }
    }

    public function tolak($id)
    {
        $data = Permintaan::find($id);
        $data->status = 'tolak';
        $data->save();
    }
    public function edit($id)
    {
        $this->idTerpilih = $id;
        $data = Permintaan::find($id);
        if (!$data->status) {
            $this->barang_id = $data->barang_id;
            $this->puskesmas_id = $data->puskesmas_id;
            $this->jumlah = $data->jumlah;
            $this->keterangan = $data->keterangan;

            $this->options = 'Edit';
        } else {
            $this->dispatchBrowserEvent('edit-fail');
        }
    }

    public function deleteKonfirm($id)
    {
        $this->idDelete = $id;
        $this->dispatchBrowserEvent('modal-delete');
    }

    public function delete($id)
    {
        $data = Permintaan::find($id);


        if ($data->status) {
            $this->dispatchBrowserEvent('delete-fail');
        } else {
            $data->delete();
            $this->resetInput();
            $this->dispatchBrowserEvent('toast-deleted');
        }
    }
}
