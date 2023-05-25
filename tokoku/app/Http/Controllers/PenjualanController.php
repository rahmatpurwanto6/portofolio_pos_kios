<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PenjualanController extends Controller
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
        return view('penjualan.index');
    }

    public function api()
    {
        $penjualan = PenjualanDetail::select('penjualan_details.*', 'produks.nama_produk')
            ->join('penjualans', 'penjualan_details.id_penjualan', '=', 'penjualans.id')
            ->join('produks', 'produks.id', '=', 'penjualan_details.id_produk')
            ->orderBy('penjualan_details.id', 'desc');
        $datatables = datatables()->of($penjualan)
            ->addIndexColumn();

        return $datatables->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $produks = Produk::all();
        $carts = Cart::where('id_user', Auth::user()->id)
            ->join('produks', 'produks.id', '=', 'carts.id_produk')
            ->select('produks.nama_produk', 'carts.*')
            ->groupBy('carts.id_produk')
            ->get();
        return view('penjualan.create', compact('produks', 'carts'));
    }

    public function add_cart(Request $request)
    {
        $produks = Produk::all();

        $harga = Produk::where('id', $request->id_produk)->first();

        if ($request->id_produk == 0) {
            $request->session()->flash('message', 'Pilih produk terlebih dahulu');
        }

        $cart_check = Cart::where('id', $request->id_produk)->first();

        if ($cart_check == null) {
            $cart = new Cart();

            $cart->id_produk = $request->id_produk;
            $cart->jumlah = $request->jumlah;
            $cart->harga_jual = $harga->harga_jual;
        } else {
            $cart = Cart::where('id_produk', $request->id)->first();
            $cart->id_produk = $request->id_produk;
            $cart->jumlah += $request->jumlah;
        }

        $cart->total = $harga->harga_jual * $request->jumlah;
        $cart->id_user = Auth::user()->id;
        $cart->save();

        // dd($cart);

        return redirect()->route('penjualan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'harga_jual' => 'required',
            'bayar' => 'required',
            'kembalian' => 'required'
        ]);

        $cartItems = Cart::where('id_user', auth()->user()->id)->get();


        foreach ($cartItems as $cartItem) {

            $penjualans = new Penjualan();
            $penjualans->id_produk = $cartItem->id_produk;
            $penjualans->jumlah = $cartItem->jumlah;
            $penjualans->bayar = $request->bayar;
            $penjualans->kembalian = $request->kembalian;
            $penjualans->id_user = auth()->user()->id;

            $penjualans->save();

            $detail = new PenjualanDetail();
            $detail->id_penjualan = $penjualans->id;
            $detail->id_produk = $cartItem->id_produk;
            $detail->harga_jual = $cartItem->harga_jual;
            $detail->jumlah = $cartItem->jumlah;
            $detail->total = $cartItem->total;
            $detail->bayar = $request->bayar;
            $detail->kembalian = $request->kembalian;
            $detail->id_user = auth()->user()->id;

            $detail->save();

            $cartItem->delete();
        }

        return redirect('penjualan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show(Penjualan $penjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(Penjualan $penjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penjualan $penjualan)
    {
        foreach ($penjualan as $key => $p) {
            DB::beginTransaction();

            try {
                // Hapus data dari tabel pertama
                DB::table('penjualans')->whereIn('id', $p->id)->delete();

                // Hapus data dari tabel kedua
                DB::table('penjualan_details')->whereIn('id', $p->id)->delete();

                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                Log::error('Terjadi kesalahan: ' . $e->getMessage());
            }
        }

        return redirect('penjualan');
    }
}
