<?php

namespace App\Http\Livewire;

use App\Models\Masuk;
use App\Models\Barang;
use App\Models\Keluar;
use Livewire\Component;
use Livewire\WithPagination;

class KeluarComponent extends Component
{
    use WithPagination;
    public $barang_id, $jumlah, $keterangan;
    public $idTerpilih, $idDelete;
    public $options = 'Tambah';
    public $barangs;

    protected $paginationTheme = 'bootstrap';
    public function mount()
    {
        $this->barangs = Barang::select(['id', 'nama_barang'])->get();
    }

    public function render()
    {
        return view('livewire.keluar-component', ['lists' => Keluar::with('barang')->paginate(10)])->extends('layouts.app')->section('content');
    }

    public function resetInput()
    {
        $this->reset(['barang_id', 'jumlah', 'keterangan', 'idTerpilih', 'idDelete', 'options']);
    }

    public function store()
    {
        $dataBarang = Barang::find($this->barang_id);

        $tes = $dataBarang->stok_akhir;

        $data = $this->validate([
            'barang_id' => 'required',
            'jumlah' => 'required|numeric|lt:' . $tes,
        ], [
            'barang_id.required' => 'Harap di pilih',
            'jumlah.numeric' => 'Inputan hanya boleh angka',
            'jumlah.required' => 'Harap di isi',
            'jumlah.lt' => 'Inputan melebihi sisa stok',
        ]);

        $data['keterangan'] = $this->keterangan;

        if ($this->idTerpilih) {
            $barangKeluarOld = Keluar::find($this->idTerpilih);
            $barang = Barang::find($this->barang_id);
            $barang->stok_akhir += $barangKeluarOld->jumlah;
            $barang->stok_akhir -= $this->jumlah;
            $barang->save();
        } else {
            $barang = Barang::find($this->barang_id);
            $barang->stok_akhir -= $this->jumlah;
            $barang->save();
        }
        Keluar::updateOrCreate(['id' => $this->idTerpilih], $data);
        session()->flash('message', $this->idTerpilih ? 'Data berhasil di rubah' : 'Data berhasil di tambah');
        $this->resetInput();
        $this->dispatchBrowserEvent('toast-success');
    }

    public function edit($id)
    {
        $this->idTerpilih = $id;
        $data = Keluar::find($id);
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
        $dataKeluar = Keluar::find($id);

        $dataBarang = Barang::find($dataKeluar->barang_id);
        $dataBarang->stok_akhir += $dataKeluar->jumlah;
        $dataBarang->save();

        $dataKeluar->delete();
        $this->idDelete;
        $this->dispatchBrowserEvent('toast-deleted');
    }
}
