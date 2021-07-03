<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Illuminate\Support\Facades\Http;

class WebhookController extends Controller
{
    public function getWebhooks()
    {
        $reqUrl = 'https://ws-use.brightpearl.com/public-api/apiworxtest3/integration-service/webhook/';
        $response = Http::withHeaders([
            'brightpearl-account-token' => '2O9fTexCIUOpRRq2R3JUcZ42diNKBeFd7vgmZe0sJxs=',
            'brightpearl-app-ref' => 'apiworxtest3_1111',
            'content-type' => 'application/json'
        ])->get($reqUrl);
        return $listWebhooks = $response->json();
    }

    public function deleteWebhooks($webhookId)
    {
        $reqUrl = 'https://ws-use.brightpearl.com/public-api/apiworxtest3/integration-service/webhook/'.$webhookId;
        $response = Http::withHeaders([
            'brightpearl-account-token' => '2O9fTexCIUOpRRq2R3JUcZ42diNKBeFd7vgmZe0sJxs=',
            'brightpearl-app-ref' => 'apiworxtest3_1111',
            'content-type' => 'application/json'
        ])->delete($reqUrl);
        return $listWebhooks = $response->json();
    }
    
    public function createWebhooks($webhookId)
    {
        $reqUrl = 'https://ws-use.brightpearl.com/public-api/apiworxtest3/integration-service/webhook/';
        $response = Http::withHeaders([
            'brightpearl-account-token' => '2O9fTexCIUOpRRq2R3JUcZ42diNKBeFd7vgmZe0sJxs=',
            'brightpearl-app-ref' => 'apiworxtest3_1111',
            'content-type' => 'application/json'])
        ->withBody([
                "subscribeTo" => "product.modified.on-hand-modified",
                "httpMethod" => "PUT",
                "uriTemplate" => "https://375924773588.ngrok.io/project2/public/webhook/product_modified",
                "bodyTemplate" => "{ \"accountCode\": \"${account-code}\", \"resourceType\": \"${resource-type}\", \"id\": \"${resource-id}\",\"lifecycleEvent\": \"${lifecycle-event}\", \"fullEvent\": \"${full-event}\", \"raisedOn\": \"${raised-on}\", \"brightpearlVersion\": \"${brightpearl-version}\" }",
                "contentType" => "application/json",
                "idSetAccepted" => true,
                "qualityOfService" => 1])
        ->post($reqUrl);
        return $listWebhooks = $response->json();
    }


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
