<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    public function getProducts()
    {   
        $response = Http::withHeaders([
            'brightpearl-account-token' => '2O9fTexCIUOpRRq2R3JUcZ42diNKBeFd7vgmZe0sJxs=',
            'brightpearl-app-ref' => 'apiworxtest3_1111',
            'content-type' => 'application/json'
        ])->get('https://ws-use.brightpearl.com/public-api/apiworxtest3/product-service/product/21090-21092');

       return $response->json();
    }
    public function getBrands()
    {
        $response = Http::withHeaders([
            'brightpearl-account-token' => '2O9fTexCIUOpRRq2R3JUcZ42diNKBeFd7vgmZe0sJxs=',
            'brightpearl-app-ref' => 'apiworxtest3_1111',
            'content-type' => 'application/json'
        ])->get('https://ws-use.brightpearl.com/public-api/apiworxtest3/product-service/brand');

       return $response->json();
    }
    
}
