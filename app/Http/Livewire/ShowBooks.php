<?php

namespace App\Http\Livewire;

use App\Models\Book;
use App\Models\Client;
use App\Models\Loan;
use Livewire\Component;
use Livewire\WithPagination;

class ShowBooks extends Component
{
    use WithPagination;

    public $search = '';
    public $titulo, $autor, $isbn, $num_pag;
    public $idEdit, $tituloEdit, $autorEdit, $isbnEdit, $num_pagEdit;
    public $selected_book_id, $selected_client_id;

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
     * Propiedad computada para obtener los libros
     */
    public function getBooksProperty()
    {
        return Book::where('titulo', 'like', '%'.$this->search.'%')
        ->orWhere('autor', 'like', '%'.$this->search.'%')
        ->orWhere('isbn', 'like', '%'.$this->search.'%')
        ->orWhere('num_pag', 'like', '%'.$this->search.'%')
        ->paginate(20) ?? [];
    }

    /**
     * Propiedad computada para obtener los usuarios, para mostrarlos
     * en el select
     */
    public function getClientsProperty()
    {
        return Client::get() ?? [];
    }

    /**
     * Este metodo se ejecuta cada vez que se actualiza el
     * campo de isbn, lo que se hace es formatearlo a solo 
     * numeros
     * Tambien lo hacemos para el de editar
     */
    public function updatedIsbn()
    {
        $this->isbn = preg_replace('([^0-9])', '', $this->isbn);
    }

    public function updatedIsbnEdit()
    {
        $this->isbnEdit = preg_replace('([^0-9])', '', $this->isbnEdit);
    }

    /**
     * Asignamos variable del libro que se quiere prestar
     */
    public function setBookId($id)
    {
        $this->selected_book_id = $id;
    }

    /**
     * Metodo para asignar el prestamo
     */
    public function lend()
    {
        //Validamos con un try catch
        try {
            $this->validate([
                'selected_book_id' => 'required|numeric',
                'selected_client_id' => 'required|numeric'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->emit('swal', 'error', 'Completa el campo');
            $this->validate([
                'selected_book_id' => 'required|numeric',
                'selected_client_id' => 'required|numeric'
            ]);
        }

        //Obtenemos el libro
        $book = Book::find($this->selected_book_id);
        //Verificamos que no este prestado
        if (!$book->prestado) {
            $book->prestado = true;
            $book->save();

            $prestamo = new Loan();
            $prestamo->book_id = $this->selected_book_id;
            $prestamo->client_id = $this->selected_client_id;
            $prestamo->fecha_prestamo = date('Y-m-d');
            $prestamo->save();

            $this->emit('swal', 'success', 'Se realizó el préstamo correctamente');
            $this->emit('closeModalPrestamo');
        } else {
            $this->emit('swal', 'error', 'Ya esta prestado');
            $this->emit('closeModalPrestamo');
        }
    }

    /**
     * Marcar como libro entregado y ya disponible
     */
    public function setBookTrue($id)
    {
        $book = Book::find($id);
        //Verificamos que el libro este prestado
        if ($book->prestado) {
            $book->prestado = false;
            $book->save();
            //Asignamos la fecha de devolucion
            $prestamo = Loan::find($book->loans->last()->id);
            $prestamo->fecha_devolucion = date('Y-m-d');
            $prestamo ->save();

            $this->emit('swal', 'success', 'Se cambió el estado correctamente');
        }
    }

    /**
     * Buscamos el libro y las asignamos a las variables de editar
     * Todavia no se actualizan los valores
     */
    public function editBook($id)
    {
        $this->idEdit = $id ?? null;
        $book = Book::find($this->idEdit);
        $this->isbnEdit = $book->isbn ?? null;
        $this->tituloEdit = $book->titulo ?? null;
        $this->autorEdit = $book->autor ?? null;
        $this->num_pagEdit = $book->num_pag ?? null;
    }

    /**
     * Metodo que actualiza los datos del libro
     */
    public function update()
    {
        //Validaciones
        $this->validate([
            'idEdit' => 'required',
            'isbnEdit' => 'required|unique:books,isbn,'.$this->idEdit,
            'tituloEdit' => 'required',
            'autorEdit' => 'required',
            'num_pagEdit' => 'required|numeric',
        ]);

        $book = Book::find($this->idEdit);
        //Verificamos que si exista el libro
        if (!empty($book)) {
            $book->isbn = $this->isbnEdit;
            $book->titulo = $this->tituloEdit;
            $book->autor = $this->autorEdit;
            $book->num_pag = $this->num_pagEdit;
            $book->save();
        }
        //Emit de alerta para dar mensaje (el script que lo recibe esta en la plantilla)
        $this->emit('swal', 'success', 'Se editó correctamente');
        //Emit para cerrar el modal (el script que lo recibe esta la vista de este componente)
        $this->emit('closeModalEdit');
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        if (!empty($book)) {
            if (!$book->prestado) {
                $book->delete();
                //Emit de alerta para dar mensaje (el script que lo recibe esta en la plantilla)
                $this->emit('swal', 'success', 'Se eliminó correctamente');
            } else {
                $this->emit('swal', 'info', 'No se puede eliminar, esta en préstamo');
            }
        }
    }

    /**
     * Metodo para guardar el libro en la BD
     */
    public function save()
    {
        //Validaciones
        $this->validate([
            'isbn' => 'required|unique:books,isbn',
            'titulo' => 'required',
            'autor' => 'required',
            'num_pag' => 'required|numeric',
        ]);

        //Guardamos el dato
        $book = new Book();
        $book->isbn = $this->isbn;
        $book->titulo = $this->titulo;
        $book->autor = $this->autor;
        $book->num_pag = $this->num_pag;
        $book->save();

        //Emit de alerta para dar mensaje (el script que lo recibe esta en la plantilla)
        $this->emit('swal', 'success', 'Se creó correctamente');
        //Emit para cerrar el modal (el script que lo recibe esta la vista de este componente)
        $this->emit('closeModalCreate');
    }

    public function render()
    {
        return view('livewire.show-books')
        ->extends('layouts.plantilla')
        ->section('content');
    }
}
