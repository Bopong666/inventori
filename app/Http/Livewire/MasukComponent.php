<?php

namespace App\Http\Livewire;

use App\Models\Masuk;
use App\Models\Barang;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class MasukComponent extends Component
{
    use WithPagination;
    public $barang_id, $jumlah, $keterangan;
    public $idTerpilih, $idDelete;
    public $options = 'Tambah';
    public $barangs;

    protected $paginationTheme = 'bootstrap';
    public function mount()
    {

        // dd(Auth::user()->level);
        if (Auth::user()->level != 'admin') {
            return abort(404);
        }
        $this->barangs = Barang::select(['id', 'nama_barang'])->get();
        // dd($this->barangs[0]->nama_barang);
    }
    public function render()
    {
        return view('livewire.masuk-component', ['lists' => Masuk::with('barang')->paginate(10)])->extends('layouts.app')->section('content');
    }

    public function resetInput()
    {
        $this->reset(['barang_id', 'jumlah', 'keterangan', 'idTerpilih', 'idDelete', 'options']);
    }

    public function store()
    {
        $data = $this->validate([
            'barang_id' => 'required',
            'jumlah' => 'required|numeric',
        ], [
            'barang_id.required' => 'Harap di pilih',
            'jumlah.numeric' => 'Inputan hanya boleh angka',
            'jumlah.required' => 'Harap di isi',
        ]);


        $data['keterangan'] = $this->keterangan;

        if ($this->idTerpilih) {
            $barangMasukOld = Masuk::find($this->idTerpilih);
            $barang = Barang::find($this->barang_id);
            $barang->stok_akhir -= $barangMasukOld->jumlah;
            $barang->stok_akhir += $this->jumlah;
            $barang->save();
        } else {
            $barang = Barang::find($this->barang_id);
            $barang->stok_akhir += $this->jumlah;
            $barang->save();
        }
        Masuk::updateOrCreate(['id' => $this->idTerpilih], $data);
        session()->flash('message', $this->idTerpilih ? 'Data berhasil di rubah' : 'Data berhasil di tambah');
        $this->resetInput();
        $this->dispatchBrowserEvent('toast-success');
    }

    public function edit($id)
    {
        $this->idTerpilih = $id;
        $data = Masuk::find($id);
        $this->barang_id = $data->barang_id;
        $this->jumlah = $data->jumlah;
        $this->keterangan = $data->keterangan;
        $this->options = 'Edit';
    }

    public function deleteKonfirm($id)
    {
        $this->idDelete = $id;
        $this->dispatchBrowserEvent('modal-delete');
    }

    public function delete($id)
    {
        $dataMasuk = Masuk::find($id);

        $dataBarang = Barang::find($dataMasuk->barang_id);
        $dataBarang->stok_akhir -= $dataMasuk->jumlah;
        $dataBarang->save();

        $dataMasuk->delete();
        $this->idDelete;
        $this->dispatchBrowserEvent('toast-deleted');
    }
}
