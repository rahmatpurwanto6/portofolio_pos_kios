<?php

namespace App\Http\Controllers;

use App\Models\PenjualanDetail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class PenjualanDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('laporan.index');
    }

    public function export(Request $request)
    {
        $tgl1 = $request->tgl1;
        $tgl2 = $request->tgl2;

        $data = DB::table('penjualan_details')
            ->select('penjualan_details.id_produk', 'penjualan_details.jumlah', 'penjualan_details.harga_jual', 'penjualan_details.total', 'penjualan_details.bayar', 'penjualan_details.kembalian', 'produks.nama_produk')
            ->whereDate('penjualan_details.created_at', '>=', $tgl1)
            ->whereDate('penjualan_details.created_at', '<=', $tgl2)
            ->join('produks', 'produks.id', '=', 'penjualan_details.id_produk')
            ->groupBy('penjualan_details.id_penjualan')
            ->get();

        $pdf = PDF::loadView('laporan.pdf', ['data' => $data]);
        return $pdf->stream();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
