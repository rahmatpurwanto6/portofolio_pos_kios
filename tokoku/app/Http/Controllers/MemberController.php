<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class MemberController extends Controller
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
        return view('member.index');
    }

    public function api()
    {
        $members = Member::all();
        $datatables = datatables()->of($members)
            ->addColumn('kode_member', function ($member) {
                return '<span class="badge bg-green">' . $member->kode_member . '</span>';
            })
            ->addIndexColumn();

        return $datatables
            ->rawColumns(['kode_member'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
        ]);


        $member = Member::selectRaw('LPAD(CONVERT(COUNT("id") + 1, char(5)) , 5,"0") as kode')->first();

        $members = new Member();
        $members->kode_member = 'M' . $member->kode;
        $members->nama = $request->nama;
        $members->alamat = $request->alamat;
        $members->telepon = $request->telepon;
        $members->save();

        // Member::create($request->all());
        return redirect('member');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
        ]);

        $member->update($request->all());
        return redirect('member');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        $member->delete();
        return redirect('member');
    }
}
