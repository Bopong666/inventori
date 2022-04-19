<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    Data Barang Keluar
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="text-center">
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Tanggal Keluar</th>
                            <th>Aksi</th>
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
                                <td>{{ $list->barang->nama_barang }}</td>
                                <td>{{$list->jumlah }}</td>
                                <td>{{$list->keterangan }}</td>
                                <td>{{$list->created_at->format('d.m.Y')
                                    }}</td>

                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="btn-group">
                                            <button class="btn btn-md btn-warning text-white"
                                                wire:click.prevent="edit({{ $list->id }})">Edit</button>
                                            <button class="btn btn-md btn-danger"
                                                wire:click="deleteKonfirm({{ $list->id }})">Delete</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">Data Kosong</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>

                <div class="card-footer text-muted" style="float: right">{{ $lists->links() }}</div>

            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    {{ $options }} Barang Keluar
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="store">
                        <div class="mb-3 row">
                            <label for="" class="col-form-label">Barang <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-control" wire:model.defer="barang_id">
                                    <option value="">Pilih Barang</option>
                                    @foreach ($barangs as $barang)
                                    <option value="{{ $barang->id }}" {{ $barang_id==$barang->id ? 'selected'
                                        : ''
                                        }}>{{ $barang->nama_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('barang_id')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Jumlah<span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" wire:model.defer="jumlah" placeholder="10">
                            </div>
                            @error('jumlah')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3 row">
                            <label for="inputName" class="col-form-label">Keterangan</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="" id="" cols="5" rows="5"
                                    wire:model.defer="keterangan">{{ $keterangan }}</textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-md">Simpan</button>
                        <button type="button" wire:click.prevent="resetInput"
                            class="btn btn-secondary btn-md">reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


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
</div>

@push('scripts')

<script>
    window.addEventListener('toast-success',()=>{        
        $('#toastId').toast('show');
        console.log('asd');
    });
    window.addEventListener('toast-deleted',()=>{
        $('#deleteId').modal('hide');    
        $('#toastDeleteId').toast('show');
    });
    window.addEventListener('modal-delete', ()=>{        
        $('#deleteId').modal('show');
    })

</script>
@endpush