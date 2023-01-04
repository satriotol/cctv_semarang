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
        $locations = Location::whereHas('cctvs')->get();
        return ResponseFormatter::success($locations, 'Sukses Mengambil Data');
    }
    public function getCctv(Request $request)
    {
        $paginate = $request->paginate;
        if ($paginate) {
            $cctvs = Cctv::getApiCctv($request)->orderBy('name')->paginate($paginate);
        }else{
            $cctvs = Cctv::getApiCctv($request)->orderBy('name')->get();
        }
        return ResponseFormatter::success($cctvs, 'Sukses Mengambil Data');
    }
    public function cctvStatus(Request $request)
    {
        $location_id = $request->location_id;
        $cctvs = Cctv::where('liveViewUrl', '!=', 'https://streaming.cctvsemarang.katalisindonesia.comnull')->where('liveViewUrl', '!=', '');
        if ($location_id) {
            $cctvs->where('location_id', $location_id);
        }
        if ($request->status) {
            $cctvs->where('status', $request->status);
        }
        $batch = Bus::batch([])->name('cctv status')->dispatch();
        foreach ($cctvs->get() as $cctv) {
            $batch->add(new CctvStatus($cctv));
        }
        return $batch;
    }
    public function cctvStatusDetail(Cctv $cctv)
    {
        if (Str::contains($cctv->liveViewUrl, 'katalisindonesia') == 1) {
            $response = Http::get($cctv->liveViewUrl);
            if (Str::contains($response, 'YES') == 1  && $response->status() == 200) {
                $cctv->update([
                    'status' => 1,
                ]);
            } else {
                $cctv->update([
                    'status' => 2,
                ]);
            }
        } elseif (Str::contains($cctv->liveViewUrl, 'livecctvpuhls') == 1) {
            $url = Str::replace("stream", "index", $cctv->liveViewUrl);
            $response = Http::get($url);
            if ($response->status() == 200) {
                $cctv->update([
                    'status' => 1,
                ]);
            } else {
                $cctv->update([
                    'status' => 2,
                ]);
            }
        }
        return back();
    }
    public function batch(Request $request)
    {
        $batchId = $request->id;
        return Bus::findBatch($batchId);
    }
    public function getFirstBatch()
    {
        $data = DB::table('job_batches')->orderByDesc('created_at')->first();
        $totalCctv = Cctv::getCctv()->count();
        $cctvHidup = Cctv::getCctv()->where('status', 1)->count();
        $cctvMati = Cctv::getCctv()->where('status', 2)->count();
        $data = [
            "nama" => $data->name,
            "total_jobs" => $data->total_jobs,
            "pending_jobs" => $data->pending_jobs,
            "done_jobs" => $data->total_jobs - $data->pending_jobs,
            "totalCctv" => $totalCctv,
            "cctvHidup" => $cctvHidup,
            "cctvMati" => $cctvMati,
        ];
        return $data;
    }
}
