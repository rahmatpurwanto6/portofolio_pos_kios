<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $kategori = DB::table('kategoris')->select(DB::raw('COUNT(nama_kategori) as total_kategori'))->get();
        $produk = DB::table('produks')->select(DB::raw('COUNT(nama_produk) as total_produk'))->get();
        $member = DB::table('members')->select(DB::raw('COUNT(nama) as total_member'))->get();
        $supplier = DB::table('suppliers')->select(DB::raw('COUNT(nama) as total_supplier'))->get();
        return view('index', compact('kategori', 'produk', 'member', 'supplier'));
        // dd($kategori);
    }
}
