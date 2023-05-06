<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class ShowUsers extends Component
{
    use WithPagination;

    public $search = '';
    public $email, $password;

    protected $paginationTheme = 'bootstrap';

    /**
     * Propiedad computada para obtener los usuarios
     */
    public function getUsersProperty()
    {
        return User::where('email', 'like', '%'.$this->search.'%')
        ->paginate(20) ?? [];
    }

    /**
     * Metodo para crear cuenta nueva
     */
    public function save()
    {
        $this->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        User::create([
            'email' => 'test@example.com',
            'password' => Hash::make(12345678),
        ]);

        //Emit de alerta para dar mensaje (el script que lo recibe esta en la plantilla)
        $this->emit('swal', 'success', 'Se creó correctamente');
        //Emit para cerrar el modal (el script que lo recibe esta la vista de este componente)
        $this->emit('closeModalCreate');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!empty($user)) {
            $user->delete();
            //Emit de alerta para dar mensaje (el script que lo recibe esta en la plantilla)
            $this->emit('swal', 'success', 'Se eliminó correctamente');
        }
    }

    public function render()
    {
        return view('livewire.show-users')
        ->extends('layouts.plantilla')
        ->section('content');
    }
}
