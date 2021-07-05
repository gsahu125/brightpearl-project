<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Illuminate\Support\Facades\Http;

class WebhookController extends Controller
{
    private $api_uri ='https://ws-use.brightpearl.com/public-api/apiworxtest3/';
    private $bp_account_token = '2O9fTexCIUOpRRq2R3JUcZ42diNKBeFd7vgmZe0sJxs=';
    private $bp_app_ref = 'apiworxtest3_1111';

    public function getWebhooks()
    {
        $response = Http::withHeaders([
            'brightpearl-account-token' => $this->bp_account_token,
            'brightpearl-app-ref' => $this->bp_app_ref,
            'content-type' => 'application/json'
        ])->get($this->api_uri.'integration-service/webhook/');
        return $listWebhooks = $response->json();
    }

    public function deleteWebhooks($webhookId)
    {
        $response = Http::withHeaders([
            'brightpearl-account-token' => $this->bp_account_token,
            'brightpearl-app-ref' => $this->bp_app_ref,
            'content-type' => 'application/json'
        ])->delete($this->api_uri.'integration-service/webhook/'.$webhookId);
        return $listWebhooks = $response->json();
    }
    
    public function createWebhooks($webhookId)
    {
        $eventName = 'product.modified.on-hand-modified';
        $webhookUrl ='https://375924773588.ngrok.io/project2/public/webhook/product_modified';
        $response = Http::withHeaders([
            'brightpearl-account-token' => $this->bp_account_token,
            'brightpearl-app-ref' => $this->bp_app_ref,
            'content-type' => 'application/json'])
        ->withBody([
                "subscribeTo" => $eventName,
                "httpMethod" => "PUT",
                "uriTemplate" => $webhookUrl,
                "bodyTemplate" => "{ \"accountCode\": \"${account-code}\", \"resourceType\": \"${resource-type}\", \"id\": \"${resource-id}\",\"lifecycleEvent\": \"${lifecycle-event}\", \"fullEvent\": \"${full-event}\", \"raisedOn\": \"${raised-on}\", \"brightpearlVersion\": \"${brightpearl-version}\" }",
                "contentType" => "application/json",
                "idSetAccepted" => true,
                "qualityOfService" => 1])
        ->post($this->api_uri.'integration-service/webhook/');

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
