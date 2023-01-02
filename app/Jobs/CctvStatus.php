<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CctvStatus implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $cctv;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($cctv)
    {
        $this->cctv = $cctv;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            if (Str::contains($this->cctv->liveViewUrl, 'katalisindonesia') == 1) {
                $response = Http::get($this->cctv->liveViewUrl);
                if (Str::contains($response, 'YES') == 1  && $response->status() == 200) {
                    $this->cctv->update([
                        'status' => 1
                    ]);
                } else {
                    $this->cctv->update([
                        'status' => 2
                    ]);
                }
            } elseif (Str::contains($this->cctv->liveViewUrl, 'livecctvpuhls') == 1) {
                $url = Str::replace("stream", "index", $this->cctv->liveViewUrl);
                $response = Http::get($url);
                if ($response->status() == 200) {
                    $this->cctv->update([
                        'status' => 1
                    ]);
                } else {
                    $this->cctv->update([
                        'status' => 2
                    ]);
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            $this->cctv->update([
                'status' => 2,
            ]);
            DB::commit();
            // DB::rollBack();
        }
    }
}
