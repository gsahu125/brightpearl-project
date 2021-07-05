<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\Brightpearl_dataController;
use App\Http\Controllers\ProductController;

use App\Http\Resources\UserResource;
use App\Models\User;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

//webhooks setup for brightpearl events
//http://127.0.0.1:8000/webhook/product_create  
Route::any('webhook/product_create',[WebhookController::class,'productCreated']);
Route::any('webhook/product_destroyed',[WebhookController::class,'productDestroyed']);
Route::any('webhook/product_modified',[WebhookController::class,'productModified']);



//Routes for fetch data first time 
Route::get('getBrands',[Brightpearl_dataController::class,'getBrands']);
Route::get('getCategories',[Brightpearl_dataController::class,'getBrightpearlCategories']);
Route::get('getCollections',[Brightpearl_dataController::class,'getCollections']);
Route::get('getOptions',[Brightpearl_dataController::class,'getOptions']);
Route::get('getProductGroups',[Brightpearl_dataController::class,'getProductGroups']);
Route::get('getProductGroups',[Brightpearl_dataController::class,'getProductGroups']);
Route::get('getproducts',[Brightpearl_dataController::class,'getproducts']);
Route::get('getProductTypes',[Brightpearl_dataController::class,'getProductTypes']);
Route::get('getSeasons',[Brightpearl_dataController::class,'getSeasons']);
Route::get('getSubCategories',[Brightpearl_dataController::class,'getSubCategory']);
Route::get('getSuppliers',[Brightpearl_dataController::class,'getSuppliers']);
Route::get('getTaxCodes',[Brightpearl_dataController::class,'getTaxCodes']);


//Routes for view
Route::resource('products', ProductController::class);



Route::get('/user/{id}', function ($id) {
    return new UserResource(User::findOrFail($id));
});
