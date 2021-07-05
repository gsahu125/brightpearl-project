<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
class ProductController extends Controller
{
    private $api_uri ='https://ws-use.brightpearl.com/public-api/apiworxtest3/';
    private $bp_account_token = '2O9fTexCIUOpRRq2R3JUcZ42diNKBeFd7vgmZe0sJxs=';
    private $bp_app_ref = 'apiworxtest3_1111';

    public function index()
    {

        return response()->json(Product::get(), 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $brandName = "LG";
        $brandId = "";
        //search brand name if found create product else first create brand then create product

        $response = Http::withHeaders([
            'brightpearl-account-token' => $this->bp_account_token,
            'brightpearl-app-ref' => $this->bp_app_ref,
            'content-type' => 'application/json'
        ])->get($this->api_uri.'product-service/brand-search?brandName='.$brandName);
        $resp = $response->json();
        $dataArray  = $resp['response']['metaData']['resultsAvailable'];

        if(!$dataArray == 0)
        {
            $brandId = isset($resp['response']['results'][0][0])? $resp['response']['results'][0][0] : '';
        }
        else
        {
            $response = Http::withHeaders([
                'brightpearl-account-token' => $this->bp_account_token,
                'brightpearl-app-ref' => $this->bp_app_ref,
                'content-type' => 'application/json'
            ])->post($this->api_uri.'product-service/brand',[
                'name' => $brandName,
	            'description' => $brandName
            ]); 
            $resp = $response->json();
            $brandId = $resp['response'];
        }

        //create Product 
        if($brandId !="")
        {
            $categoryId = "296";
            $taxId = "3";
            $productName = "mytestproduct";
            $productCondition ="new";

            $response1 = Http::withHeaders([
                'brightpearl-account-token' => $this->bp_account_token,
                'brightpearl-app-ref' => $this->bp_app_ref,
                'content-type' => 'application/json'
            ])
            ->post($this->api_uri.'product-service/product/',[
                'brandId' => $brandId,
                "productTypeId" => "3",
                "financialDetails" => [
                    "taxCode" => [
                        "id" => $taxId,
                    ]
                ],
                "salesChannels" => [
                    [
                        "salesChannelName" => "Brightpearl",
                        "productName" => $productName,
                        "productCondition" => $productCondition,
                        "categories" => [
                            [
                                "categoryCode" => "318"
                            ],
                            [
                                "categoryCode" => "317"
                            ]
                        ],
                        "description" => [
                            "languageCode" => "en",
                            "text" => "Music is everything",
                            "format" => "HTML_FRAGMENT"
                        ],
                        "shortDescription"=> [
                            "languageCode"=> "en",
                            "text"=> "test description",
                            "format"=> "HTML_FRAGMENT"
                        ],
                    ],
                ]
            ]); 

            $resp = $response1->json();
            return "Product Created With Id - ".$productId = $resp['response'];
    
            
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
