<?php

namespace App\Http\Livewire;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

class ShowClients extends Component
{
    use WithPagination;

    public $search = '';
    public $nombre, $apellidos, $tipo_doc, $num_doc, $fecha_nacimiento, $direccion, $telefono;
    public $idEdit, $nombreEdit, $apellidosEdit, $tipo_docEdit, $num_docEdit, $fecha_nacimientoEdit, $direccionEdit, $telefonoEdit;

    protected $paginationTheme = 'bootstrap';

    /**
     * Metodo que se ejecuta cuando se actualiza la variable search
     * que es el buscador de la tabla
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Propiedad computada para obtener los usuarios
     */
    public function getClientsProperty()
    {
        return Client::where('nombre', 'like', '%'.$this->search.'%')
        ->orWhere('apellidos', 'like', '%'.$this->search.'%')
        ->orWhere('tipo_doc', 'like', '%'.$this->search.'%')
        ->orWhere('num_doc', 'like', '%'.$this->search.'%')
        ->orWhere('fecha_nacimiento', 'like', '%'.$this->search.'%')
        ->orWhere('direccion', 'like', '%'.$this->search.'%')
        ->orWhere('telefono', 'like', '%'.$this->search.'%')
        ->paginate(20) ?? [];
    }

    /**
     * Obtenemos los datos del usuario y los guardamos en la variables de editar
     */
    public function editClient($id)
    {
        $this->idEdit = $id ?? null;
        $client = Client::find($this->idEdit);
        $this->nombreEdit = $client->nombre;
        $this->apellidosEdit = $client->apellidos;
        $this->tipo_docEdit = $client->tipo_doc;
        $this->num_docEdit = $client->num_doc;
        $this->fecha_nacimientoEdit = $client->fecha_nacimiento;
        $this->direccionEdit = $client->direccion;
        $this->telefonoEdit = $client->telefono;
    }

    /**
     * Metodo para actualizar los datos del cliente
    */
    public function update()
    {
        //Validamos los campos
        $this->validate([
            'idEdit' => 'required',
            'nombreEdit' => 'required',
            'apellidosEdit' => 'required',
            'tipo_docEdit' => 'required',
            'num_docEdit' => 'required|unique:clients,num_doc,'.$this->idEdit,
            'fecha_nacimientoEdit' => 'required',
            'direccionEdit' => 'nullable',
            'telefonoEdit' => 'nullable',
        ]);

        $usuario = Client::find($this->idEdit);
        if (!empty($usuario)) {
            $usuario->nombre = $this->nombreEdit;
            $usuario->apellidos = $this->apellidosEdit;
            $usuario->tipo_doc = $this->tipo_docEdit;
            $usuario->num_doc = $this->num_docEdit;
            $usuario->fecha_nacimiento = $this->fecha_nacimientoEdit;
            $usuario->direccion = $this->direccionEdit;
            $usuario->telefono = $this->telefonoEdit;
            $usuario->save();
        }

        //Emit de alerta para dar mensaje (el script que lo recibe esta en la plantilla)
        $this->emit('swal', 'success', 'Se editó correctamente');
        //Emit para cerrar el modal (el script que lo recibe esta la vista de este componente)
        $this->emit('closeModalEdit');
    }

    /**
     * Metodo para eliminar un usuario
     */
    public function destroy($id)
    {
        $usuario = Client::find($id);
        if (!empty($usuario)) {
            $usuario->delete();
            //Emit de alerta para dar mensaje (el script que lo recibe esta en la plantilla)
            $this->emit('swal', 'success', 'Se eliminó correctamente');
        }
    }

    /**
     * Metodo para guardar usuario en la BD
     */
    public function save()
    {
        //Validamos los campos
        $this->validate([
            'nombre' => 'required',
            'apellidos' => 'required',
            'tipo_doc' => 'required',
            'num_doc' => 'required|unique:clients,num_doc',
            'fecha_nacimiento' => 'required',
            'direccion' => 'nullable',
            'telefono' => 'nullable',
        ]);

        $usuario = new Client();
        $usuario->nombre = $this->nombre;
        $usuario->apellidos = $this->apellidos;
        $usuario->tipo_doc = $this->tipo_doc;
        $usuario->num_doc = $this->num_doc;
        $usuario->fecha_nacimiento = $this->fecha_nacimiento;
        $usuario->direccion = $this->direccion;
        $usuario->telefono = $this->telefono;
        $usuario->save();

        //Emit de alerta para dar mensaje (el script que lo recibe esta en la plantilla)
        $this->emit('swal', 'success', 'Se creó correctamente');
        //Emit para cerrar el modal (el script que lo recibe esta la vista de este componente)
        $this->emit('closeModalCreate');
    }

    public function render()
    {
        return view('livewire.show-clients')
        ->extends('layouts.plantilla')
        ->section('content');
    }
}
