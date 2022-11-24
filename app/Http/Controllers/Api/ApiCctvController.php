<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\CctvStatus;
use App\Models\Cctv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ApiCctvController extends Controller
{
    public function cctvStatus(Request $request)
    {
        $job = new CctvStatus();
        $this->dispatch($job);
        return "ExampleJob dan HelloWorldJob sedang dijalankan!";
    }
}
