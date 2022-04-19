<?php

namespace App\Http\Livewire;

use App\Models\Puskesmas;
use Livewire\Component;
use Livewire\WithPagination;

class PuskesmasComponent extends Component
{
    use WithPagination;
    public $puskesmas;
    public $idTerpilih, $idDelete;
    public $options = 'Tambah';

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.puskesmas-component', ['lists' => Puskesmas::paginate(10)])->extends('layouts.app')->section('content');
    }

    public function resetInput()
    {
        $this->reset(['puskesmas', 'idTerpilih', 'idDelete', 'options']);
    }
    public function store()
    {
        $data = $this->validate([
            'puskesmas' => 'required|string',
        ], [
            'puskesmas.required' => 'Harap isi data nya'
        ]);
        Puskesmas::updateOrCreate(['id' => $this->idTerpilih], $data);

        session()->flash('message', $this->idTerpilih ? 'Data berhasil di rubah' : 'Data berhasil di tambah');
        $this->resetInput();

        $this->dispatchBrowserEvent('toast-success');
    }

    public function edit($id)
    {
        $this->idTerpilih = $id;
        $data = Puskesmas::find($id);
        $this->puskesmas = $data->puskesmas;
        $this->options = 'Edit';
    }

    public function deleteKonfirm($id)
    {
        $this->idDelete = $id;
        $this->dispatchBrowserEvent('modal-delete');
    }
    public function delete($id)
    {
        Puskesmas::destroy($id);
        session()->flash('message', 'Data berhasil dihapus');
        $this->dispatchBrowserEvent('toast-deleted');
    }
}
