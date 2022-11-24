<?php

namespace App\Jobs;

use App\Models\Cctv;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CctvStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Request $request)
    {
        $cctvs = Cctv::where('liveViewUrl', '!=', 'https://streaming.cctvsemarang.katalisindonesia.comnull')->where('liveViewUrl', '!=', '');
        if ($request->status) {
            $cctvs->where('STATUS', $request->status);
        }
        usleep(100000);
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
    }
}
