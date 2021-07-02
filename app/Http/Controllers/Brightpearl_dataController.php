<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Brand;
use App\Models\Brightpearl_category;
use App\Models\Option;
use App\Models\Option_value;
use App\Models\Product;
use App\Models\Product_type;
use App\Models\Tax_code;
use App\Models\Season;

use Illuminate\Support\Arr;

class Brightpearl_dataController extends Controller
{
    public function getBrands()
    {
        $response = Http::withHeaders([
            'brightpearl-account-token' => '2O9fTexCIUOpRRq2R3JUcZ42diNKBeFd7vgmZe0sJxs=',
            'brightpearl-app-ref' => 'apiworxtest3_1111',
            'content-type' => 'application/json'
        ])->get('https://ws-use.brightpearl.com/public-api/apiworxtest3/product-service/brand');

        $brandArray = $response->json();
        //print_r($brandArray['response']);
        Brand::insert($brandArray['response']);
        return "Record inserted";
        
    }  
    
    public function getBrightpearlCategories()
    {
        $response = Http::withHeaders([
            'brightpearl-account-token' => '2O9fTexCIUOpRRq2R3JUcZ42diNKBeFd7vgmZe0sJxs=',
            'brightpearl-app-ref' => 'apiworxtest3_1111',
            'content-type' => 'application/json'
        ])->get('https://ws-use.brightpearl.com/public-api/apiworxtest3/product-service/brightpearl-category');
        
        $categoryArray = $response->json();
        $dataArray  = $categoryArray['response'];
        
        foreach($dataArray as $data)
        {
            $categoryLists[] = [
            'id' => $data['id'],
            'name' => $data['name'],
            'parentId' => $data['parentId'],
            'active' => $data['active'],
            'createdOn' => $data['createdOn'],
            'createdById' => $data['createdById'],
            'updatedOn' => $data['updatedOn'],
            'updatedById' => $data['updatedById'],
            //'description_text' => $data['description'],
            ];
        }
        // print_r($categoryLists);
        // die();
        Brightpearl_category::insert($categoryLists);
        return "Record inserted";

    }

    public function getCollections()
    {
        //
    }

    public function getOptions()
    {   
        $response = Http::withHeaders([
            'brightpearl-account-token' => '2O9fTexCIUOpRRq2R3JUcZ42diNKBeFd7vgmZe0sJxs=',
            'brightpearl-app-ref' => 'apiworxtest3_1111',
            'content-type' => 'application/json'
        ])->get('https://ws-use.brightpearl.com/public-api/apiworxtest3/product-service/option');

        $optionsArray = $response->json();
        $dataArray  = $optionsArray['response'];
        // print_r($dataArray);
        // die();
        Option::insert($dataArray);
        return "Record inserted";
    }

    public function getOptionValues()
    {
        $response = Http::withHeaders([
            'brightpearl-account-token' => '2O9fTexCIUOpRRq2R3JUcZ42diNKBeFd7vgmZe0sJxs=',
            'brightpearl-app-ref' => 'apiworxtest3_1111',
            'content-type' => 'application/json'
        ])->get('https://ws-use.brightpearl.com/public-api/apiworxtest3/product-service/option');

        $optionsValueArray = $response->json();
        $dataArray  = $optionsValueArray['response'];
        // print_r($dataArray);
        // die();
        Option_value::insert($dataArray);
        return "Record inserted";
    }

    public function getProductGroups()
    {
        //
    }

    public function getproducts()
    {   
        $response = Http::withHeaders([
            'brightpearl-account-token' => '2O9fTexCIUOpRRq2R3JUcZ42diNKBeFd7vgmZe0sJxs=',
            'brightpearl-app-ref' => 'apiworxtest3_1111',
            'content-type' => 'application/json'
        ])->get('https://ws-use.brightpearl.com/public-api/apiworxtest3/product-service/product/21090-21092');
        
        $productArray = $response->json();
        $dataArray  = $productArray['response'];
        print_r($dataArray);
        die();
        foreach($dataArray as $data)
        {
            $productList [] = [
                'id' => $data['id'],
                'brandId' => $data['brandId'],
                'collectionId' => '1',
                'productTypeId' => $data['productTypeId'],
                'seasonIds' => '',
                'identity_sku' => $data['identity']['sku'],
                'identity_isbn' => $data['identity']['isbn'],
                'identity_ean' => $data['identity']['ean'],
                'identity_upc' => $data['identity']['upc'],
                'identity_barcode' => $data['identity']['barcode'],
                'productGroupId' => '1',
                'featured' => $data['featured'],
                'stock_stockTracked' => $data['stock']['stockTracked'],
                'stock_dimensions' => $data['stock']['dimensions']['length'],
                'financialDetails_taxCode_id' => '1',
                'salesChannels_salesChannelName' => '',
                'salesChannels_productName' => '',
                'salesChannels_productCondition' => '',
                'salesChannels_categories_categoryCode' => '',
                'salesChannels_description_text' => '',
                'salesChannels_shortDescription_text' => '',
                'variations_optionId' => '',
                'variations_optionValueId' => '',
                'warehouses' => '',
                'createdOn' => $data['createdOn'],
                'updatedOn' => $data['updatedOn'],
                'reporting_categoryId' => $data['reporting']['categoryId'],
                'reporting_subcategoryId' => '',
                'reporting_seasonId' => '',
                'primarySupplierId' => '1',
                'status' => $data['status'],
                'salesPopupMessage' => $data['salesPopupMessage'],
                'version' => $data['version']
            ];
        }
        if(Product::insert($productList))
        {
            echo"Data inserted";
        }
        else
        {
            echo"some thing went wrong";
        }
    }   

    public function getProductTypes()
    {
        $response = Http::withHeaders([
            'brightpearl-account-token' => '2O9fTexCIUOpRRq2R3JUcZ42diNKBeFd7vgmZe0sJxs=',
            'brightpearl-app-ref' => 'apiworxtest3_1111',
            'content-type' => 'application/json'
        ])->get('https://ws-use.brightpearl.com/public-api/apiworxtest3/product-service/product-type/');
        
        $productTypeArray = $response->json();
        $dataArray  = $productTypeArray['response'];
        foreach($dataArray as $data)
        {
            $productTypeList [] = [
                'id' => $data['id'],
                'name' => $data['name'],
            ];
        }
        if(Product_type::insert($productTypeList))
        {
            echo"product type inserted";
        }
        else
        {
            echo"there is something went wrong";
        }

    }
    public function getSeasons()
    {
        $response = Http::withHeaders([
            'brightpearl-account-token' => '2O9fTexCIUOpRRq2R3JUcZ42diNKBeFd7vgmZe0sJxs=',
            'brightpearl-app-ref' => 'apiworxtest3_1111',
            'content-type' => 'application/json'
        ])->get('https://ws-use.brightpearl.com/public-api/apiworxtest3/product-service/season/');
        $seasonArray = $response->json();
        $dataArray  = $seasonArray['response'];

        // foreach($dataArray as $data)
        // {
        //     $find = Season::find($data['id']);
        //     if (!$find) {
        //         DB::table('seasons')->insert(
        //         [ 'id'=>$data['id'],'name'=>$data['name'],'description'=>$data['description'],'dateFrom'=>$data['dateFrom'],'dateTo'=>$data['dateTo'] ]
        //         );
        //     } else {
        //         DB::table('seasons')
        //         ->where('id', $data['id'])
        //         ->update([ 'name'=>$data['name'],'description'=>$data['description'],'dateFrom'=>$data['dateFrom'],'dateTo'=>$data['dateTo'] ]);
        //     }   
        // }
       
        if(Season::insert($dataArray))
        {
            echo"data inserted";
        }
        else
        {
            echo"there is something went wrong";
        }

    }
    public function getSubCategory()
    {

    }
    public function getSuppliers()
    {

    }
    public function getTaxCodes()
    {
        $response = Http::withHeaders([
            'brightpearl-account-token' => '2O9fTexCIUOpRRq2R3JUcZ42diNKBeFd7vgmZe0sJxs=',
            'brightpearl-app-ref' => 'apiworxtest3_1111',
            'content-type' => 'application/json'
        ])->get('https://ws-use.brightpearl.com/public-api/apiworxtest3/accounting-service/tax-code?columns=id,code,description,rate');
        
        $taxCodeArray = $response->json();
        $dataArray  = $taxCodeArray['response'];
        
        foreach($dataArray as $data)
        {
            $TaxCodeList [] = [
                'id' => isset($data['id'])? $data['id']:'',
                'code' => isset($data['code'])? $data['code']:'',
                'description' => isset($data['description'])? $data['description']:'',
                'rate' => isset($data['rate'])? $data['rate']:'',
            ];
        }
        if(Tax_code::insert($TaxCodeList))
        {
            echo"Tax Code inserted";
        }
        else
        {
            echo"there is something went wrong";
        }

    }
}
