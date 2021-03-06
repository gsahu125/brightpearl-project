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
use App\Models\Supplier;


use Illuminate\Support\Arr;

class Brightpearl_dataController extends Controller
{
    private $api_uri ='https://ws-use.brightpearl.com/public-api/apiworxtest3/';
    private $bp_account_token = '2O9fTexCIUOpRRq2R3JUcZ42diNKBeFd7vgmZe0sJxs=';
    private $bp_app_ref = 'apiworxtest3_1111';

    public function getBrands()
    {
        $response = Http::withHeaders([
            'brightpearl-account-token' => $this->bp_account_token,
            'brightpearl-app-ref' => $this->bp_app_ref,
            'content-type' => 'application/json'
        ])->get($this->api_uri.'product-service/brand');

        $brandArray = $response->json();
        foreach($brandArray as $data)
        {
            $find = Brand::find($data['id']);
            if(!$find){
                //
            }
            else
            {
                //
            }
        }
        
        //print_r($brandArray['response']);
        Brand::insert($brandArray['response']);
        return "Record inserted";
        
    }  
    
    public function getBrightpearlCategories()
    {
        $response = Http::withHeaders([
            'brightpearl-account-token' => $this->bp_account_token,
            'brightpearl-app-ref' => $this->bp_app_ref,
            'content-type' => 'application/json'
        ])->get($this->api_uri.'product-service/brightpearl-category');
        
        $categoryArray = $response->json();
        $dataArray  = $categoryArray['response'];
        
        foreach($dataArray as $data)
        {
            $categoryLists[] = [
            'id' => isset($data['id'])? $data['id'] : '',
            'name' => isset($data['name'])? $data['name'] : '',
            'parentId' => isset($data['parentId'])? $data['parentId'] : '',
            'active' => isset($data['active'])? $data['active'] : '',
            'createdOn' => isset($data['createdOn'])? $data['createdOn'] : '',
            'createdById' => isset($data['createdById'])? $data['createdById'] : '',
            'updatedOn' => isset($data['updatedOn'])? $data['updatedOn'] : '',
            'updatedById' => isset($data['updatedById'])? $data['updatedById'] : '',
            'description_text' => isset($data['description']['text'])? $data['description']['text'] : '',
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
            'brightpearl-account-token' => $this->bp_account_token,
            'brightpearl-app-ref' => $this->bp_app_ref,
            'content-type' => 'application/json'
        ])->get($this->api_uri.'product-service/option');

        $optionsArray = $response->json();
        $dataArray  = $optionsArray['response'];
        Option::insert($dataArray);
        return "Record inserted";
    }

    public function getOptionValues()
    {
        $response = Http::withHeaders([
            'brightpearl-account-token' => $this->bp_account_token,
            'brightpearl-app-ref' => $this->bp_app_ref,
            'content-type' => 'application/json'
        ])->get($this->api_uri.'product-service/option');

        $optionsValueArray = $response->json();
        $dataArray  = $optionsValueArray['response'];
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
            'brightpearl-account-token' => $this->bp_account_token,
            'brightpearl-app-ref' => $this->bp_app_ref,
            'content-type' => 'application/json'
        ])->get($this->api_uri.'product-service/product/21113-21115');
        
        $productArray = $response->json();
        $dataArray  = $productArray['response'];
        // print_r($dataArray);
        // die();
       
        foreach($dataArray as $data)
        {
            //print_r($data['salesChannels'][0]['salesChannelName']);
            $productList [] = [
                'id' => isset($data['id'])? $data['id']:'',
                'brandId' => isset($data['brandId'])? $data['brandId'] :'',
                'collectionId' => isset($data['collectionId'])? $data['collectionId'] :'',
                'productTypeId' => isset($data['productTypeId'])? $data['productTypeId'] :'',
                'seasonIds' => '1',
                'identity_sku' => isset($data['identity']['sku'])? $data['identity']['sku'] :'',
                'identity_isbn' => isset($data['identity']['isbn'])? $data['identity']['isbn'] :'',
                'identity_ean' => isset($data['identity']['ean'])? $data['identity']['ean'] :'',
                'identity_upc' => isset($data['identity']['upc'])? $data['identity']['upc'] : '',
                'identity_barcode' => isset($data['identity']['barcode'])? $data['identity']['barcode'] : '',
                'productGroupId' => isset($data['productGroupId']) ? $data['productGroupId'] : '',
                'featured' => isset($data['featured']) ? $data['featured'] : '',
                'stock_stockTracked' => isset($data['stock']['stockTracked'])? $data['stock']['stockTracked'] : '',
                'stock_dimensions' => isset($data['stock']['dimensions']['length'])? $data['stock']['dimensions']['length'] : '',
                'financialDetails_taxCode_id' => isset($data['financialDetails']['taxCode_id'])? $data['financialDetails']['taxCode_id'] : '',
                'salesChannels_salesChannelName' => isset($data['salesChannels'][0]['salesChannelName'])? $data['salesChannels'][0]['salesChannelName'] : '',
                'salesChannels_productName' => isset($data['salesChannels'][0]['productName'])? $data['salesChannels'][0]['productName'] : '',
                'salesChannels_productCondition' => isset($data['salesChannels'][0]['productCondition'])? $data['salesChannels'][0]['productCondition'] : '',
                'salesChannels_categories_categoryCode' => isset($data['salesChannels'][0]['categories'][0]['categoryCode'])? $data['salesChannels'][0]['categories'][0]['categoryCode'] : '',
                'salesChannels_description_text' => isset($data['salesChannels'][0]['description']['text'])? $data['salesChannels'][0]['description']['text'] : '',
                'salesChannels_shortDescription_text' => isset($data['salesChannels'][0]['shortDescription']['text'])? $data['salesChannels'][0]['shortDescription']['text'] : '',
                'variations_optionId' => isset($data['variations']['optionId'])? $data['variations']['optionId'] : '',
                'variations_optionValueId' => isset($data['variations']['optionValueId'])? $data['variations']['optionValueId'] : '',
                'warehouses' => '1',
                'createdOn' => isset($data['createdOn'])? $data['createdOn'] : '',
                'updatedOn' => isset($data['updatedOn'])? $data['updatedOn'] : '',
                'reporting_categoryId' => isset($data['reporting']['categoryId'])? $data['reporting']['categoryId'] : '',
                'reporting_subcategoryId' => isset($data['reporting']['subcategoryId'])? $data['reporting']['subcategoryId'] : '',
                'reporting_seasonId' => isset($data['reporting']['seasonId'])? $data['reporting']['seasonId'] : '',
                'primarySupplierId' => isset($data['primarySupplierId'])? $data['primarySupplierId'] : '',
                'status' => isset($data['status'])? $data['status'] : '',
                'salesPopupMessage' => isset($data['salesPopupMessage'])? $data['salesPopupMessage'] : '',
                'version' => isset($data['version'])? $data['version'] : '',
            ];
        }
        print_r($productList);
        die();

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
            'brightpearl-account-token' => $this->bp_account_token,
            'brightpearl-app-ref' => $this->bp_app_ref,
            'content-type' => 'application/json'
        ])->get($this->api_uri.'product-service/product-type/');
        
        $productTypeArray = $response->json();
        $dataArray  = $productTypeArray['response'];
        foreach($dataArray as $data)
        {
            $productTypeList [] = [
                'id' => isset($data['id'])? $data['id'] : '',
                'name' => isset($data['name'])? $data['name'] : '',
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
            'brightpearl-account-token' => $this->bp_account_token,
            'brightpearl-app-ref' => $this->bp_app_ref,
            'content-type' => 'application/json'
        ])->get($this->api_uri.'product-service/season/');
        $seasonArray = $response->json();
        $dataArray  = $seasonArray['response'];

        foreach($dataArray as $data)
        {
            $find = Season::find($data['id']);
            if (!$find) {
                DB::table('seasons')->insert(
                [ 
                'id'=> isset($data['id'])? $data['id'] : '',
                'name'=> isset($data['name'])? $data['name'] :'',
                'description'=> isset($data['description'])? $data['description'] : '',
                'dateFrom'=> isset($data['dateFrom'])? $data['dateFrom'] : '',
                'dateTo'=> isset($data['dateTo'])? $data['dateTo'] : '', 
                ]);
            }  
        }
        
        // if(Season::insert($dataArray))
        // {
        //     echo"data inserted";
        // }
        // else
        // {
        //     echo"there is something went wrong";
        // }

    }
    public function getSubCategory()
    {

    }
    public function getSuppliers()
    {
        $response = Http::withHeaders([
            'brightpearl-account-token' => $this->bp_account_token,
            'brightpearl-app-ref' => $this->bp_app_ref,
            'content-type' => 'application/json'
        ])->get($this->api_uri.'contact-service/contact-search?columns=contactId,primaryEmail,secondaryEmail,firstName,lastName,isSupplier,nominalCode,title,companyName,pri,mob&isSupplier=true');
        
        $taxCodeArray = $response->json();
        $dataArray  = $taxCodeArray['response']['results'];
        array_walk($dataArray, function (& $item) {
            $item['contactId'] = $item[0];
            $item['primaryEmail'] = $item[1];
            $item['secondaryEmail'] = $item[2];
            $item['firstName'] = $item[3];
            $item['lastName'] = $item[4];
            $item['isSupplier'] = $item[5];
            $item['nominalCode'] = $item[6];
            $item['title'] = $item[7];
            $item['companyName'] = $item[8];
            $item['pri'] = $item[9];
            $item['mob'] = $item[10];
            unset($item[0],$item[1],$item[2],$item[3],$item[4],$item[5],$item[6],$item[7],$item[8],$item[9],$item[10]);
         });

        // print_r($dataArray);
        // die();

        if(Supplier::insert($dataArray))
        {
            echo"Suppliers inserted";
        }
       

    }
    public function getTaxCodes()
    {
        $response = Http::withHeaders([
            'brightpearl-account-token' => $this->bp_account_token,
            'brightpearl-app-ref' => $this->bp_app_ref,
            'content-type' => 'application/json'
        ])->get($this->api_uri.'accounting-service/tax-code?columns=id,code,description,rate');
        
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
