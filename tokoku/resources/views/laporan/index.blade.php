@extends('layouts.template_index')

@section('header', 'Laporan')

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
                            Pilih Tanggal</a>
                    </div>

                    <div class="box-body table-responsive">
                        <table class="table table-bordered" id="example1">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Sub Total</th>
                                    <th>Bayar</th>
                                    <th>Kembalian</th>
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
                        <h4 class="modal-title">Pilih Berdasarkan Tanggal</h4>
                    </div>
                    <form action="{{ route('details.export') }}" method="post" target="_blank">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama">Tanggal Awal</label>
                                <input type="date" name="tgl1" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="nama">Tanggal Akhir</label>
                                <input type="date" name="tgl2" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane-o"></i>
                                Pilih</button>
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
        var url = '{{ url('penjualan') }}';
        var apiUrl = '{{ url('api/penjualan') }}';

        var columns = [{
                data: 'DT_RowIndex',
                class: 'text-center',
                width: '30px',
                orderable: false
            }, {
                data: 'nama_produk',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'jumlah',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'harga_jual',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'total',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'bayar',
                class: 'text-center',
                orderable: false
            },
            {
                data: 'kembalian',
                class: 'text-center',
                orderable: false
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
                    console.log(id);
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
