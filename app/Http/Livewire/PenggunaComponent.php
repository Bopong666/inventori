<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PenggunaComponent extends Component
{
    use WithPagination;
    public $name, $email, $password, $password_confirmation, $level;
    public $idTerpilih, $idDelete;
    public $options = 'Tambah';

    public function render()
    {
        if (Auth::user()->level != 'admin') {
            return abort(404);
        }
        return view('livewire.pengguna-component', ['lists' => User::paginate(10)])->extends('layouts.app')->section('content');
    }

    public function resetInput()
    {
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'level',  'idTerpilih', 'idDelete', 'options']);
    }

    public function store()
    {
        if ($this->idTerpilih) {
            $data = $this->validate(
                [
                    'name' => "required",
                    'email' => "required|email",
                    'password' => 'required|confirmed',
                    'level' => 'required',
                ],
                [
                    'name.required' => 'Harap di isi',
                    'email.unique' => 'Email ini telah terdaftar',
                    'email.required' => 'Harap di isi',
                    'pasword.required' => 'Harap di isi',
                    'password.confirmed' => 'Password berbeda',
                ]
            );
        } else {
            $data = $this->validate(
                [
                    'name' => "required",
                    'email' => "required|email|unique:users,email",
                    'password' => 'required|confirmed',
                    'level' => 'required',
                ],
                [
                    'name.required' => 'Harap di isi',
                    'email.unique' => 'Email ini telah terdaftar',
                    'email.required' => 'Harap di isi',
                    'pasword.required' => 'Harap di isi',
                    'password.confirmed' => 'Password berbeda',
                ]
            );
        }


        $data['password'] = Hash::make($data['password']);
        User::updateOrCreate(['id' => $this->idTerpilih], $data);

        session()->flash('message', $this->idTerpilih ? 'Data berhasil di rubah' : 'Data berhasil di tambah');
        $this->resetInput();
        $this->dispatchBrowserEvent('toast-success');
    }
    public function edit($id)
    {
        $this->idTerpilih = $id;
        $data = User::find($id);
        $this->name = $data->name;
        $this->email = $data->email;
        $this->password = $data->password;
        $this->level = $data->level;

        $this->options = 'Edit';

        $this->dispatchBrowserEvent('modal-pengguna');
    }

    public function deleteKonfirm($id)
    {
        $this->idDelete = $id;
        $this->dispatchBrowserEvent('modal-delete');
    }
    public function delete()
    {
        User::destroy($this->idDelete);

        $this->resetInput();

        $this->dispatchBrowserEvent('toast-deleted');
    }

    public function gantiRole($id, $role)
    {
        User::where('id', $id)->update(['level' => $role]);
        session()->flash('message', 'Level berhasil di rubah');

        $this->dispatchBrowserEvent('role-berhasil');
    }
}
