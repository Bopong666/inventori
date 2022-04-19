<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Data Barang

                    @if (Auth::user()->level == 'admin')
                    <button class="btn btn-md btn-primary" wire:click.prevent="resetInput" style="float: right"
                        data-bs-toggle="modal" data-bs-target="#modelId">Tambah
                        Data</button>
                    @endif

                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="text-center">
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Kategori</th>
                            <th>Nama Barang</th>
                            <th>Stok Awal</th>
                            <th>Sisa Stok</th>
                            <th>Keterangan</th>
                            @if (Auth::user()->level == 'admin')
                            <th>Aksi</th>
                            @endif
                        </thead>
                        <tbody>
                            @forelse($lists as $list)
                            <tr>
                                <td>{{ ($lists->currentpage()-1) *
                                    $lists->perpage()
                                    + $loop->index + 1
                                    }}</td>
                                @php
                                if($list->id > 9){
                                $kode_barang = 'P00'.$list->id;
                                }else{
                                $kode_barang = 'P000'.$list->id;
                                }

                                @endphp
                                <td>{{$kode_barang }}</td>
                                <td>{{ $list->kategori->kategori }}</td>
                                <td>{{ $list->nama_barang }}</td>
                                <td>{{ $list->stok_awal }}</td>
                                <td>{{ $list->stok_akhir }}</td>
                                <td>{{{ $list->keterangan }}}</td>
                                @if (Auth::user()->level == 'admin')
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
                                @endif

                            </tr>
                            @empty
                            <tr class="text-center">
                                <td colspan="7">Data kosong</td>
                            </tr>

                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-muted" style="float: right">
                    {{ $lists->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- Modal CREATE AND UPDATE-->
    <div wire:ignore.self class="modal fade" id="modelId" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
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
                                <label for="inputName" class="col-sm-2 col-form-label">Nama Barang<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" wire:model.defer="nama_barang"
                                        placeholder="Paramex">
                                </div>
                                @error('nama_barang')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 row">
                                <label for="" class="col-sm-2 col-form-label">Kategori <span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <select class="form-control" wire:model.defer="kategori_id">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" {{ $kategori_id==$kategori->id ? 'selected'
                                            : ''
                                            }}>{{ $kategori->kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('kategori_id')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3 row">
                                <label for="inputName" class="col-sm-2 col-form-label">Stok Awal<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" wire:model.defer="stok_awal"
                                        placeholder="10">
                                </div>
                                @error('stok_awal')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="mb-3 row">
                                <label for="inputName" class="col-sm-2 col-form-label">Keterangan</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="" id="" cols="5" rows="5"
                                        wire:model.defer="keterangan">{{ $keterangan }}</textarea>
                                </div>
                            </div>
                            {{-- @php
                            dd($fasilitas);
                            @endphp --}}
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

    <!-- Modal -->
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
    window.addEventListener('modal-barang',() =>{
        $('#modelId').modal('toggle');
    });
    window.addEventListener('modal-delete',() =>{
        $('#deleteId').modal('show');
    });
    
</script>
@endpush