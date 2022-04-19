<?php

namespace App\Http\Livewire;

use App\Models\Masuk;
use App\Models\Barang;
use App\Models\Permintaan;
use Livewire\Component;
use App\Models\Kategori;
use Livewire\WithPagination;

class BarangComponent extends Component
{
    use WithPagination;
    public $nama_barang, $stok_awal, $kategori_id, $keterangan;
    public $kategoris;
    public $idTerpilih, $idDelete;
    public $options = 'Tambah';

    protected $paginationTheme = 'bootstrap';
    public function mount()
    {
        $this->kategoris = Kategori::all();
    }
    public function render()
    {
        return view('livewire.barang-component', ['lists' => Barang::with('kategori')->paginate(10)])->extends('layouts.app')->section('content');
    }

    public function resetInput()
    {
        $this->reset(['nama_barang', 'stok_awal', 'kategori_id', 'keterangan', 'idTerpilih', 'idDelete', 'options']);
    }

    public function store()
    {

        $data = $this->validate([
            'nama_barang' => 'required|string',
            'stok_awal' => 'required|numeric',
            'kategori_id' => 'required',

        ], [
            'nama_barang.required' => 'Harap diisi',
            'stok_awal.numeric' => 'mesti angka',
            'kategori_id.required' => 'Harap di pilih'
        ]);

        $data['keterangan'] = $this->keterangan;

        if ($this->idTerpilih) {

            $totalBarangMasuk = Masuk::where('barang_id', $this->idTerpilih)->sum('jumlah');
            $totalBarangPermintaan = Permintaan::where('barang_id', $this->idTerpilih)->sum('jumlah');
            $data['stok_akhir'] = $data['stok_awal'] + $totalBarangMasuk - $totalBarangPermintaan;
        } else {
            $data['stok_akhir'] = $this->stok_awal;
        }

        Barang::updateOrCreate(['id' => $this->idTerpilih], $data);
        session()->flash('message', $this->idTerpilih ? 'Data berhasil di rubah' : 'Data berhasil di tambah');
        $this->resetInput();
        $this->dispatchBrowserEvent('toast-success');
    }

    public function edit($id)
    {
        $this->idTerpilih = $id;
        $data = Barang::find($id);
        $this->nama_barang = $data->nama_barang;
        $this->stok_awal = $data->stok_awal;
        $this->kategori_id = $data->kategori_id;
        $this->keterangan = $data->keterangan;
        $this->options = "Edit";
        $this->dispatchBrowserEvent('modal-barang');
    }

    public function deleteKonfirm($id)
    {
        $this->idDelete = $id;
        $this->dispatchBrowserEvent('modal-delete');
    }

    public function delete($id)
    {
        Barang::destroy($id);
        $this->resetInput();
        $this->dispatchBrowserEvent('toast-deleted');
    }
}
