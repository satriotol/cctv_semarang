<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseFormatter;
use App\Jobs\CctvStatus;
use App\Models\Cctv;
use App\Models\Location;
use Illuminate\Bus\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ApiCctvController extends Controller
{
    public function getLocation()
    {
        $locations = Location::all();
        return ResponseFormatter::success($locations, 'Sukses Mengambil Data');
    }
    public function getCctv(Request $request)
    {
        $cctvs = Cctv::getApiCctv($request)->inRandomOrder()->paginate();
        return ResponseFormatter::success($cctvs, 'Sukses Mengambil Data');
    }
    public function cctvStatus(Request $request)
    {
        $cctvs = Cctv::where('liveViewUrl', '!=', 'https://streaming.cctvsemarang.katalisindonesia.comnull')->where('liveViewUrl', '!=', '');
        if ($request->status) {
            $cctvs->where('STATUS', $request->status);
        }
        $batch = Bus::batch([])->name('cctv status')->dispatch();
        foreach ($cctvs->get() as $cctv) {
            $batch->add(new CctvStatus($cctv));
        }
        return $batch;
    }
    public function batch(Request $request)
    {
        $batchId = $request->id;
        return Bus::findBatch($batchId);
    }
}
