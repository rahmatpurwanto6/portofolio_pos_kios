@extends('layouts.template_index')

@section('header', 'Transaksi')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets') }}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" id="theme-styles">
@endsection

@section('content')
    <section class="content">
        <a href="{{ route('penjualan.index') }}" class="btn btn-info" style="margin-bottom: 2px;"><i
                class="fa fa-arrow-circle-left"></i>
            Kembali</a>
        <div class="row">
            @if ($message = Session::get('message'))
                <div class="col-md-12">
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                </div>
            @endif

            <div class="col-md-4">

                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Pilih Produk</h3>
                    </div>


                    <form class="form-horizontal" method="POST" action="{{ route('penjualan.add_cart') }}">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Produk</label>
                                <div class="col-sm-10">
                                    <select name="id_produk" class="form-control">
                                        <option value="0"></option>
                                        @foreach ($produks as $produk)
                                            <option value="{{ $produk->id }}">{{ $produk->nama_produk }} -
                                                {{ $produk->harga_jual }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Jumlah</label>
                                <div class="col-sm-10">
                                    <input type="number" name="jumlah" class="form-control" required>
                                </div>
                            </div>


                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary pull-right">Tambah</button>
                            </div>

                    </form>
                </div>
            </div>

        </div>

        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Transaksi</h3>
                </div>


                <form method="POST" action="{{ route('penjualan.store') }}">
                    @csrf
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="box-body table-responsive">
                                    <table class="table table-bordered" id="example1">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Produk</th>
                                                <th>Harga</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($carts as $cart)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $cart->nama_produk }}</td>
                                                    <td>{{ $cart->harga_jual }}</td>
                                                    <td>{{ $cart->jumlah }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group pull-right">
                                    <label>Sub Total</label>
                                    @if ($carts)
                                        <input type="text" name="harga_jual" id="total"
                                            value="{{ $carts->sum('total') }}">
                                    @endif
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="form-group pull-right">
                                    <label>Bayar</label>
                                    <input type="text" name="bayar" id="bayar">
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="form-group pull-right">
                                    <label>Kembalian</label>
                                    <input type="text" name="kembalian" id="kembalian">
                                </div>

                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary pull-right">Checkout</button>
                    </div>
                </form>
            </div>

        </div>

    </section>

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#total, #bayar").keyup(function() {
                var total = $("#total").val();
                var bayar = $("#bayar").val();

                var kembalian = parseInt(bayar) - parseInt(total);
                $("#kembalian").val(kembalian);
            });
        });
    </script>
@endsection

@endsection
