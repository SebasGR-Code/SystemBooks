<div>
    <div class="pb-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0)">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Libros</a></li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Libros</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Boton modal para crear libro -->
        <div class="col-12 d-flex justify-content-start">  
            <button type="button" class="btn btn-block btn-gray-800 mb-3" data-bs-toggle="modal" data-bs-target="#createBook">
                <i class="las la-plus"></i> Crear libro
            </button>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="createBook" tabindex="-1" aria-labelledby="createBookLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Libro nuevo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>ISBN</label>
                        <input type="number" class="form-control @error('isbn') is-invalid @enderror" wire:model="isbn">
                        @error('isbn')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Titulo</label>
                        <input type="text" class="form-control @error('titulo') is-invalid @enderror" wire:model="titulo">
                        @error('titulo')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Autor</label>
                        <input type="text" class="form-control @error('autor') is-invalid @enderror" wire:model="autor">
                        @error('autor')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label>Número de Páginas</label>
                        <input type="number" class="form-control @error('num_pag') is-invalid @enderror" wire:model="num_pag">
                        @error('num_pag')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" wire:click="save">Guardar</button>
                </div>
            </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <input type="text" class="form-control mb-3" placeholder="Buscar..." wire:model="search">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0 rounded">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0 rounded-start">ISBN</th>
                                    <th class="border-0">Titulo</th>
                                    <th class="border-0">Autor</th>
                                    <th class="border-0">Número de Páginas</th>
                                    <th class="border-0">Estado</th>
                                    <th class="border-0 rounded-end"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($this->books as $book)  
                                    <tr>
                                        <td>
                                            {{$book->isbn}}
                                        </td>
                                        <td>
                                            {{$book->titulo}}
                                        </td>
                                        <td>
                                            {{$book->autor}}
                                        </td>
                                        <td>
                                            {{$book->num_pag}}
                                        </td>
                                        <td>
                                            @if ($book->prestado)
                                                <span class="badge bg-danger">Prestado</span>
                                            @else
                                                <span class="badge bg-success">Disponible</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-row">
                                               <!-- Boton modal para prestar libro -->
                                                @if (!$book->prestado)
                                                    <button type="button" class="btn btn-sm btn-gray-800 mx-2" data-bs-toggle="modal" data-bs-target="#prestarLibro" wire:click="setBookId({{$book->id}})">
                                                        Prestar
                                                    </button>
                                                @else  
                                                    <button type="button" class="btn btn-sm btn-success text-white mx-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Marcar como libro entregado" wire:click="setBookTrue({{$book->id}})">
                                                        <i class="las la-check la-lg"></i>
                                                    </button>
                                                @endif
                                                    <button type="button" class="btn btn-sm btn-secondary mx-2" data-bs-toggle="modal" data-bs-target="#editBook" wire:click="editBook({{$book->id}})">
                                                        <i class="las la-pencil-alt la-lg"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#prestamos{{$book->id}}">
                                                        <i class="las la-history la-lg"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-danger mx-2 {{$book->prestado ? 'disabled' : ''}}" wire:click="$emit('deleteBook', {{$book->id}})">
                                                        <i class="las la-trash-alt la-lg"></i>
                                                    </button>
                                                    <!-- Modal para ver historial-->
                                                    <div class="modal fade" id="prestamos{{$book->id}}" tabindex="-1" aria-labelledby="prestamos{{$book->id}}Label" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Historial</h1>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-centered table-nowrap mb-0 rounded">
                                                                            <thead class="thead-light">
                                                                                <tr>
                                                                                    <th class="border-0 rounded-start">Fecha de prestamo</th>
                                                                                    <th class="border-0">Fecha de devolución</th>
                                                                                    <th class="border-0 rounded-end">Usuario</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                @forelse ($book->loans as $loan)  
                                                                                    <tr>
                                                                                        <td>
                                                                                            {{$loan->fecha_prestamo}}
                                                                                        </td>
                                                                                        <td>
                                                                                            {{$loan->fecha_devolucion ?? 'El usuario no lo ha entregado'}}
                                                                                        </td>
                                                                                        <td>
                                                                                            {{$loan->client->nombre}} {{$loan->client->apellidos}} - {{$loan->client->tipo_doc}} {{$loan->client->num_doc}}
                                                                                        </td>
                                                                                    </tr>
                                                                                @empty
                                                                                    <tr>
                                                                                        <td colspan="8" class="text-center"> 
                                                                                            No hay historico
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforelse
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center"> 
                                            No hay libros
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        {{ $this->books->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar libro -->
    <div class="modal fade" id="editBook" tabindex="-1" aria-labelledby="editBookLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Editar libro</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>ISBN</label>
                    <input type="number" class="form-control @error('isbnEdit') is-invalid @enderror" wire:model="isbnEdit">
                    @error('isbnEdit')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Titulo</label>
                    <input type="text" class="form-control @error('tituloEdit') is-invalid @enderror" wire:model="tituloEdit">
                    @error('tituloEdit')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Autor</label>
                    <input type="text" class="form-control @error('autorEdit') is-invalid @enderror" wire:model="autorEdit">
                    @error('autorEdit')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Número de Páginas</label>
                    <input type="number" class="form-control @error('num_pagEdit') is-invalid @enderror" wire:model="num_pagEdit">
                    @error('num_pagEdit')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" wire:click="update">Guardar</button>
            </div>
        </div>
        </div>
    </div>

    <!-- Modal para prestar libro -->
    <div class="modal fade" id="prestarLibro" tabindex="-1" aria-labelledby="prestarLibroLabel" aria-hidden="true" wire:ignore>
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Préstamo de Libro</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Usuario</label><br>
                    <select class="form-control" id="js-example-basic-single" style="width: 100%">
                        <option selected="">Selecciona un usuario</option>
                        @foreach ($this->clients as $client)
                            <option value="{{$client->id}}">{{$client->nombre}} {{$client->apellidos}} - {{$client->tipo_doc}} {{$client->num_doc}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" wire:click="lend">Guardar</button>
            </div>
        </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('livewire:load', function () {
            //Utilizamos select2 para buscar usuarios
            $('#js-example-basic-single').select2({
                dropdownParent: $('#prestarLibro')
            });
            //Escuchamos el cambio del select y lo asignamos a una variable del componente
            $('#js-example-basic-single').on('change', function (e) {
                var data = $('#js-example-basic-single').select2("val");
                @this.set('selected_client_id', data);
            });

            //Aca cerramos el modal de creacion de libro
            Livewire.on('closeModalCreate', function () {
                let myModalEl = document.getElementById('createBook')
                let modal = bootstrap.Modal.getInstance(myModalEl)
                modal.hide()
            });
            //Aca cerramos el modal de prestamo
            Livewire.on('closeModalPrestamo', function () {
                let myModalEl = document.getElementById('prestarLibro')
                let modal = bootstrap.Modal.getInstance(myModalEl)
                modal.hide()
            });
            //Aca cerramos el modal de editar libro
            Livewire.on('closeModalEdit', function () {
                let myModalEl = document.getElementById('editBook')
                let modal = bootstrap.Modal.getInstance(myModalEl)
                modal.hide()
            });
            //Emit que muestra alerta para confirmar la eliminacion
            Livewire.on('deleteBook', (id) => {
                Swal.fire({
                    title: 'Estas seguro?',
                    text: "Se borrará todo lo relacionado a este libro",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, borrar!'
                }).then((result) => {
                if (result.isConfirmed) {
                    // Metodo para eliminar
                    @this.destroy(id)
                }
                })
            });
        })
    </script>
@endpush
