<?php

namespace App\Http\Controllers;

use App\Models\Cctv;
use Illuminate\Http\Request;

class CctvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:cctv-index|cctv-create|cctv-edit|cctv-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:cctv-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:cctv-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:cctv-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $cctvs = Cctv::all();
        return view('backend.cctv.index', compact('cctvs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.cctv.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ]);

        Cctv::create($data);
        session()->flash('success');
        return redirect(route('cctv.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cctv  $cctv
     * @return \Illuminate\Http\Response
     */
    public function show(Cctv $cctv)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cctv  $cctv
     * @return \Illuminate\Http\Response
     */
    public function edit(Cctv $cctv)
    {
        return view('backend.cctv.create', compact('cctv'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cctv  $cctv
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cctv $cctv)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cctv  $cctv
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cctv $cctv)
    {
        //
    }
}
