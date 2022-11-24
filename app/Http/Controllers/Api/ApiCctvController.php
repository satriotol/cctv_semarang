<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cctv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ApiCctvController extends Controller
{
    public function cctvStatus(Request $request)
    {
        $cctvs = Cctv::where('liveViewUrl', '!=', 'https://streaming.cctvsemarang.katalisindonesia.comnull')->where('liveViewUrl', '!=', '');
        if ($request->status) {
            $cctvs->where('STATUS', $request->status);
        }
        foreach ($cctvs->get() as $cctv) {
            $response = Http::get($cctv->liveViewUrl);
            DB::beginTransaction();
            try {
                if ($response->status() == 200 && Str::contains($response, 'YES') == 1) {
                    $cctv->update([
                        'status' => 1
                    ]);
                } else {
                    $cctv->update([
                        'status' => 2
                    ]);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return $e->getMessage();
            }
        }
        return 'done';
    }
}
