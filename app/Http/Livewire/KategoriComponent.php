<?php

namespace App\Http\Livewire;

use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithPagination;

class KategoriComponent extends Component
{
    use WithPagination;
    public $kategori;
    public $idTerpilih, $idDelete;
    public $options = 'Tambah';
    public function render()
    {
        return view('livewire.kategori-component', ['lists' => Kategori::paginate(10)])->extends('layouts.app')->section('content');
    }

    public function resetInput()
    {
        $this->reset(['kategori', 'idTerpilih', 'idDelete', 'options']);
    }

    public function store()
    {
        $data = $this->validate([
            'kategori' => 'required|string',
        ], [
            'kategori.required' => 'Harap isi data nya',
        ]);

        Kategori::updateOrCreate(['id' => $this->idTerpilih], $data);
        session()->flash('message', $this->idTerpilih ? 'Data berhasil di rubah' : 'Data berhasil di tambah');
        $this->resetInput();
        $this->dispatchBrowserEvent('toast-success');
    }
    public function edit($id)
    {
        $this->idTerpilih = $id;
        $data = Kategori::find($id);
        $this->kategori = $data->kategori;
        $this->options = 'Edit';
    }

    public function deleteKonfirm($id)
    {
        $this->idDelete = $id;
        $this->dispatchBrowserEvent('modal-delete');
    }

    public function delete($id)
    {
        Kategori::destroy($id);
        $this->dispatchBrowserEvent('toast-deleted');
    }
}
