<?php

namespace App\Http\Controllers;

use App\Models\Cctv;
use App\Models\Kelurahan;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $cctvs = Cctv::getCctv();
        return view('backend.cctv.index', compact('cctvs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::all();
        $kelurahans = Kelurahan::all();
        return view('backend.cctv.create', compact('locations', 'kelurahans'));
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
            'location_id' => 'required',
            'kelurahan_id' => 'nullable',
        ]);
        $data['user_id'] = Auth::user()->id;
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
        $locations = Location::all();
        $kelurahans = Kelurahan::all();
        return view('backend.cctv.create', compact('cctv', 'locations', 'kelurahans'));
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
        $data = $request->validate([
            'name' => 'required',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'location_id' => 'required',
            'kelurahan_id' => 'nullable',
        ]);
        $cctv->update($data);
        session()->flash('success');
        return redirect(route('cctv.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cctv  $cctv
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cctv $cctv)
    {
        $cctv->delete();
        session()->flash('success');
        return redirect(route('cctv.index'));
    }
}
