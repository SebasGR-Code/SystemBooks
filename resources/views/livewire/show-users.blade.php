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
                        <label>Correo</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" wire:model="email">
                    </div>
                    <div class="mb-3">
                        <label>Contraseña</label>
                        <input type="text" class="form-control @error('password') is-invalid @enderror" wire:model="password">
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
                                    <th class="border-0 rounded-start">Correo</th>
                                    <th class="border-0 rounded-end"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($this->users as $user)  
                                    <tr>
                                        <td>
                                            {{$user->email}}
                                        </td>
                                        <td>
                                            <div class="d-flex flex-row">
                                                <button type="button" class="btn btn-sm btn-danger mx-2" wire:click="$emit('deleteUser', {{$user->id}})">
                                                    <i class="las la-trash-alt la-lg"></i>
                                                </button>
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
                        {{ $this->users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        document.addEventListener('livewire:load', function () {
            //Aca cerramos el modal de creacion de cuenta
            Livewire.on('closeModalCreate', function () {
                let myModalEl = document.getElementById('createUsuario')
                let modal = bootstrap.Modal.getInstance(myModalEl)
                modal.hide()
            });

            //Emit que muestra alerta para confirmar la eliminacion
            Livewire.on('deleteUser', (id) => {
                Swal.fire({
                    title: 'Estas seguro?',
                    text: "Se borrará todo lo relacionado a esta cuenta",
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


