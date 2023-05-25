@extends('layouts.template_index')

@section('header', 'Produk')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" id="theme-styles">
@endsection

@section('content')
    <div id="controller">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <a class="btn btn-primary" @click="addData()"><i class="fa fa-plus-circle"></i>
                            Tambah Produk</a>
                        @if (session()->has('message'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                {{ session('message') }}
                            </div>
                        @endif
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-bordered" id="example1">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Merk</th>
                                    <th>Nama Kategori</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Stok</th>
                                    <th>Diskon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Produk</h4>
                    </div>
                    <form :action="url" method="post" @submit="submitForm($event, data.id)">
                        <div class="modal-body">
                            @csrf

                            <input type="hidden" name="_method" value="PUT" v-if="editStatus">
                            <div class="form-group">
                                <label>Nama Produk</label>
                                <input type="text" name="nama_produk" class="form-control" :value="data.nama_produk">
                            </div>
                            <div class="form-group">
                                <label>Merk</label>
                                <input type="text" name="merk" class="form-control" :value="data.merk">
                            </div>
                            <div class="form-group">
                                <label>Nama Kategori</label>
                                <select name="id_kategori" class="form-control" :value="data.id_kategori">
                                    <option value=""></option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Harga Beli</label>
                                <input type="text" name="harga_beli" class="form-control" :value="data.harga_beli">
                            </div>
                            <div class="form-group">
                                <label>Harga Jual</label>
                                <input type="text" name="harga_jual" class="form-control" :value="data.harga_jual">
                            </div>
                            <div class="form-group">
                                <label>Stok</label>
                                <input type="text" name="stok" class="form-control" :value="data.stok">
                            </div>
                            <div class="form-group">
                                <label>Diskon</label>
                                <input type="number" name="diskon" class="form-control" :value="data.diskon">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@section('js')
    <script src="{{ asset('assets') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>


    <script>
        var url = '{{ url('produk') }}';
        var apiUrl = '{{ url('api/produk') }}';

        var columns = [{
                data: 'DT_RowIndex',
                class: 'text-center',
                width: '30px',
                orderable: false
            },

            {
                data: 'kode_produk',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'nama_produk',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'merk',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'nama_kategori',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'harga_beli',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'harga_jual',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'stok',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'diskon',
                class: 'text-center',
                orderable: false
            },
            {
                render: function(index, row, data, meta) {
                    return `
                <a class="btn btn-primary btn-sm" onclick="controller.editData(event, ${meta.row})"><i class="fa fa-edit"></i> Edit</a>
                <a class="btn btn-danger btn-sm" onclick="controller.deleteData(event, ${data.id})"><i class="fa fa-trash"></i> Hapus</a>
            `
                },
                orderable: false,
                width: '200px',
                class: 'text-center'
            },
        ];
    </script>

    <script>
        var controller = new Vue({
            el: '#controller',
            data: {
                datas: [], //untuk menampung data dari controller
                data: {}, //untuk crud
                url,
                apiUrl,
                editStatus: false,
            },
            mounted: function() {
                this.datatable();
            },
            methods: {
                datatable() {
                    const _this = this;
                    _this.table = $('#example1').DataTable({
                        ajax: {
                            url: _this.apiUrl,
                            type: 'GET'
                        },
                        columns: columns
                    }).on('xhr', function() {
                        _this.datas = _this.table.ajax.json().data;
                    });
                },
                addData() {
                    this.data = {};
                    this.editStatus = false;
                    $('#modal-default').modal();
                },
                editData(event, row, data) {
                    this.data = this.datas[row];
                    this.editStatus = true;
                    $('#modal-default').modal();
                },
                deleteData(event, id) {
                    if (confirm('Are you sure delete this data?')) {
                        $(event.target).parents('tr').remove();
                        axios.post(this.url + '/' + id, {
                            _method: 'DELETE'
                        }).then(response => {
                            // alert('Data succesfully delete');
                            Swal.fire({
                                title: 'Success',
                                text: 'Data successfully delete!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            this.table.ajax.reload();
                        });
                    }
                },
                submitForm(event, id) {
                    event.preventDefault();
                    const _this = this;
                    var url = !this.editStatus ? this.url : this.url + '/' + id;
                    axios.post(url, new FormData($(event.target)[0])).then(response => {
                        $('#modal-default').modal('hide');
                        _this.table.ajax.reload();

                        if (this.editStatus == false) {
                            Swal.fire({
                                title: 'Success',
                                text: 'Data successfully submitted!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        } else {
                            Swal.fire({
                                title: 'Success',
                                text: 'Data successfully update!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    })
                }
            }
        });
    </script>

    <script>
        $(function() {
            $('#example1').DataTable()
        });
    </script>


@endsection

@endsection
