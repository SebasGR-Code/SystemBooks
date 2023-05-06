<div>
    <div class="pb-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0)">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Usuarios</a></li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Usuarios</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Boton modal para crear libro -->
        <div class="col-12 d-flex justify-content-start">  
            <button type="button" class="btn btn-block btn-gray-800 mb-3" data-bs-toggle="modal" data-bs-target="#createUsuario">
                <i class="las la-plus"></i> Crear usuario
            </button>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="createUsuario" tabindex="-1" aria-labelledby="createUsuarioLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Usuario nuevo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" wire:model="nombre">
                    </div>
                    <div class="mb-3">
                        <label>Apellidos</label>
                        <input type="text" class="form-control @error('apellidos') is-invalid @enderror" wire:model="apellidos">
                    </div>
                    <div class="mb-3">
                        <label>Tipo de Documento</label>
                        <select class="form-select @error('tipo_doc') is-invalid @enderror"  wire:model="tipo_doc">
                            <option selected="">Selecciona el tipo de documento</option>
                            <option value="TI">Tarjeta de Identidad</option>
                            <option value="CC">Cedula de Ciudadania</option>
                            <option value="Pasaporte">Pasaporte</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Número de Documento</label>
                        <input type="number" class="form-control @error('num_doc') is-invalid @enderror" wire:model="num_doc">
                    </div>
                    <div class="mb-3">
                        <label>Fecha de Nacimiento</label>
                        <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" wire:model="fecha_nacimiento">
                    </div>
                    <div class="mb-3">
                        <label>Direccion</label>
                        <input type="text" class="form-control @error('direccion') is-invalid @enderror" wire:model="direccion">
                    </div>
                    <div class="mb-3">
                        <label>Teléfono</label>
                        <input type="text" class="form-control @error('telefono') is-invalid @enderror" wire:model="telefono">
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
                                    <th class="border-0 rounded-start">Nombre</th>
                                    <th class="border-0">Apellidos</th>
                                    <th class="border-0">Tipo de Documento</th>
                                    <th class="border-0">Número de Documento</th>
                                    <th class="border-0">Fecha de Nacimiento</th>
                                    <th class="border-0">Direccion</th>
                                    <th class="border-0">Teléfono</th>
                                    <th class="border-0 rounded-end"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($this->clients as $client)  
                                    <tr>
                                        <td>
                                            {{$client->nombre}}
                                        </td>
                                        <td>
                                            {{$client->apellidos}}
                                        </td>
                                        <td>
                                            {{$client->tipo_doc}}
                                        </td>
                                        <td>
                                            {{$client->num_doc}}
                                        </td>
                                        <td>
                                            {{$client->fecha_nacimiento}}
                                        </td>
                                        <td>
                                            {{$client->direccion}}
                                        </td>
                                        <td>
                                            {{$client->telefono}}
                                        </td>
                                        <td>
                                            <div class="d-flex flex-row">
                                                <button type="button" class="btn btn-sm btn-secondary mx-2" data-bs-toggle="modal" data-bs-target="#editarUsuario" wire:click="editClient({{$client->id}})">
                                                    <i class="las la-pencil-alt la-lg"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#prestamos{{$client->id}}">
                                                    <i class="las la-history la-lg"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger mx-2" wire:click="$emit('deleteUser', {{$client->id}})">
                                                    <i class="las la-trash-alt la-lg"></i>
                                                </button>
                                                <!-- Modal para ver historial-->
                                                <div class="modal fade" id="prestamos{{$client->id}}" tabindex="-1" aria-labelledby="prestamos{{$client->id}}Label" aria-hidden="true">
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
                                                                                <th class="border-0 rounded-start">Libro</th>
                                                                                <th class="border-0">Fecha de prestamo</th>
                                                                                <th class="border-0 rounded-end">Fecha de devolución</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @forelse ($client->loans as $loan)  
                                                                                <tr>
                                                                                    <td>
                                                                                        {{$loan->book->titulo}}
                                                                                    </td>
                                                                                    <td>
                                                                                        {{$loan->fecha_prestamo}}
                                                                                    </td>
                                                                                    <td>
                                                                                        {{$loan->fecha_devolucion ?? 'El usuario no lo ha entregado'}}
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
                                        <td colspan="8" class="text-center"> 
                                            No hay usuarios
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-4">
                        {{ $this->clients->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar -->
    <div class="modal fade" id="editarUsuario" tabindex="-1" aria-labelledby="editarUsuarioLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Editar usuario</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Nombre</label>
                    <input type="text" class="form-control @error('nombreEdit') is-invalid @enderror" wire:model="nombreEdit">
                </div>
                <div class="mb-3">
                    <label>Apellidos</label>
                    <input type="text" class="form-control @error('apellidosEdit') is-invalid @enderror" wire:model="apellidosEdit">
                </div>
                <div class="mb-3">
                    <label>Tipo de Documento</label>
                    <select class="form-select @error('tipo_docEdit') is-invalid @enderror"  wire:model="tipo_docEdit">
                        <option selected="">Selecciona el tipo de documento</option>
                        <option value="TI">Tarjeta de Identidad</option>
                        <option value="CC">Cedula de Ciudadania</option>
                        <option value="Pasaporte">Pasaporte</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Número de Documento</label>
                    <input type="number" class="form-control @error('num_docEdit') is-invalid @enderror" wire:model="num_docEdit">
                </div>
                <div class="mb-3">
                    <label>Fecha de Nacimiento</label>
                    <input type="date" class="form-control @error('fecha_nacimientoEdit') is-invalid @enderror" wire:model="fecha_nacimientoEdit">
                </div>
                <div class="mb-3">
                    <label>Direccion</label>
                    <input type="text" class="form-control @error('direccionEdit') is-invalid @enderror" wire:model="direccionEdit">
                </div>
                <div class="mb-3">
                    <label>Teléfono</label>
                    <input type="text" class="form-control @error('telefonoEdit') is-invalid @enderror" wire:model="telefonoEdit">
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" wire:click="update">Guardar</button>
            </div>
        </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('livewire:load', function () {
            //Aca cerramos el modal de creacion de usuario
            Livewire.on('closeModalCreate', function () {
                let myModalEl = document.getElementById('createUsuario')
                let modal = bootstrap.Modal.getInstance(myModalEl)
                modal.hide()
            });
            //Aca cerramos el modal de editar usuario
            Livewire.on('closeModalEdit', function () {
                let myModalEl = document.getElementById('editarUsuario')
                let modal = bootstrap.Modal.getInstance(myModalEl)
                modal.hide()
            });
            //Emit que muestra alerta para confirmar la eliminacion
            Livewire.on('deleteUser', (id) => {
                Swal.fire({
                    title: 'Estas seguro?',
                    text: "Se borrará todo lo relacionado a este usuario",
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

