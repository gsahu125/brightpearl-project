<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Illuminate\Support\Facades\Http;

class WebhookController extends Controller
{
    public function testWebhook(Request $request)
    {   
        $txt = "Hello world! this web hook is working";
        Storage::put('testwebhook.txt', $txt);
    }


}
