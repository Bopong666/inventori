<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Data Pengguna
                    <button class="btn btn-md btn-primary" wire:click.prevent="resetInput" style="float: right"
                        data-bs-toggle="modal" data-bs-target="#modelId">Tambah
                        Data</button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="text-center">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>level</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            @forelse($lists as $list)
                            <tr>
                                <td>{{ ($lists->currentpage()-1) *
                                    $lists->perpage()
                                    + $loop->index + 1
                                    }}</td>
                                <td>{{ $list->name }}</td>
                                <td>{{ $list->email }}</td>
                                <td>
                                    <select class="form-control" name="" id=""
                                        wire:change="gantiRole({{ $list->id }}, $event.target.value)">
                                        <option value="admin" {{ $list->level == "admin" ? 'selected' : '' }}
                                            >admin
                                        </option>
                                        <option value="pengurus" {{ $list->level == "pengurus" ? 'selected' : ''
                                            }} >pengurus</option>
                                        <option value="user" {{ $list->level == "user" ? 'selected' : '' }}
                                            >user
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="btn-group">
                                            <button class="btn btn-md btn-warning"
                                                wire:click.prevent="edit({{ $list->id }})">Edit</button>
                                            <button class="btn btn-md btn-danger"
                                                wire:click.prevent="deleteKonfirm({{ $list->id }})">Delete</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="7">Data kosong</td>
                            </tr>

                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-muted">
                    Footer
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="modelId" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $options }} Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetInput"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form wire:submit.prevent="store" enctype="multipart/form-data">
                            <div class="mb-3 row">
                                <label for="inputName" class="col-sm-2 col-form-label">Nama<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" wire:model.defer="name" placeholder="admin">
                                </div>
                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Email<span class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" wire:model.defer="email"
                                        placeholder="iniemail@gmail.com">
                                </div>
                                @error('email')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3 row">
                                <label for="inputName" class="col-sm-2 col-form-label">Password<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" wire:model.defer="password"
                                        placeholder="akugantengsekali1234">
                                </div>
                                @error('password')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3 row">
                                <label for="inputName" class="col-sm-2 col-form-label">Repeat Password<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" wire:model.defer="password_confirmation"
                                        placeholder="akugantengsekali1234">
                                </div>

                            </div>

                            <div class="mb-3 row">
                                <label for="" class=" col-sm-2 col-form-label">Level</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="" id="" wire:model.defer="level">
                                        <option selected>Select one</option>
                                        <option value="admin">admin</option>
                                        <option value="pengurus">pengurus</option>
                                        <option value="user">user</option>
                                    </select>
                                </div>
                                @error('level')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                    wire:click="resetInput">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @if(session()->has('message'))
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
        <div id="toastId" class="toast align-items-center text-white bg-primary border-0" role="alert"
            aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('message') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif

    <div wire:ignore.self class="modal fade" id="deleteId" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin mau menghapus? Data ini akan mempengaruhi data lainnya yang
                    bersangkutan
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" wire:click="delete({{ $idDelete }})">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
        <div id="toastDeleteId" class="toast align-items-center text-white bg-danger border-0" role="alert"
            aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="d-flex">
                <div class="toast-body">
                    Data berhasil Dihapus
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    window.addEventListener('toast-success',() =>{
        $('#modelId').modal('hide');
        $('#toastId').toast('show');
    });
    window.addEventListener('toast-deleted',() =>{
        $('#deleteId').modal('hide');
        $('#toastDeleteId').toast('show');
    });
    window.addEventListener('modal-pengguna',() =>{
        $('#modelId').modal('toggle');
    });
    window.addEventListener('modal-delete',() =>{
        $('#deleteId').modal('show');
    });
    window.addEventListener('role-berhasil',() =>{
        $('#toastId').toast('show');
    });
</script>
@endpush