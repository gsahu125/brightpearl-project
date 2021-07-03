<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Illuminate\Support\Facades\Http;

class WebhookController extends Controller
{
    //functions for brightpearl events
    public function productCreated(Request $request)
    {   
        $txt = "NewProduct created";
        Storage::put('testwebhook.txt', $txt);
    }

    public function productDestroyed(Request $request)
    {
        //delete product from db by request ID
    }

    public function productModified(Request $request)
    {
        $txt = "Product Modified";
        Storage::put('testwebhook.txt', $txt);
    }

    

}
