@extends('layouts.template_index')

@section('header', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-cube"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Kategori</span>
                    @foreach ($kategori as $data)
                        <span class="info-box-number">{{ $data->total_kategori }}</span>
                    @endforeach
                </div>

            </div>

        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-cubes"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Produk</span>
                    @foreach ($produk as $data)
                        <span class="info-box-number">{{ $data->total_produk }}</span>
                    @endforeach
                </div>

            </div>

        </div>


        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-truck"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Supplier</span>
                    @foreach ($supplier as $data)
                        <span class="info-box-number">{{ $data->total_supplier }}</span>
                    @endforeach
                </div>

            </div>

        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Member</span>
                    @foreach ($member as $data)
                        <span class="info-box-number">{{ $data->total_member }}</span>
                    @endforeach
                </div>

            </div>

        </div>

    </div>
@endsection
