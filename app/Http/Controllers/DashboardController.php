<?php

namespace App\Http\Controllers;

use App\Models\Cctv;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCctv = Cctv::getCctv()->count();
        $cctvHidup = Cctv::getCctv()->where('status', 1)->count();
        $cctvMati = Cctv::getCctv()->where('status', 2)->count();
        return view('backend.dashboard', compact('totalCctv', 'cctvHidup', 'cctvMati'));
    }
}
