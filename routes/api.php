<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\ListCardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware' => 'hasAccess'], function(){

    // List Cards apis
    Route::get('list-cards/list',[ListCardController::class, 'getListCards']);
    Route::post('list-card/create',[ListCardController::class, 'createListCard']);
    Route::get('list-card/{id}/delete',[ListCardController::class, 'deleteListCard']);

    // Cards apis
    Route::get('cards/list',[CardController::class, 'getCards']);
    Route::post('card/create',[CardController::class, 'createCard']);
    Route::post('card/update',[CardController::class, 'updateCard']);
    Route::get('card/{id}/delete',[CardController::class, 'deleteCard']);
    Route::post('card/order/change',[CardController::class, 'changeCardOrder']);
    // download database
    Route::get('/dump', function () {
        Spatie\DbDumper\Databases\MySql::create()
        ->setDbName(env('DB_DATABASE'))
        ->setUserName(env('DB_USERNAME'))
        ->setPassword(env('DB_PASSWORD'))
        ->setHost(env('DB_HOST'))
        ->setPort(env('DB_PORT'))
        ->dumpToFile('dump.sql');
        $file = public_path('dump.sql');
        return response()->download($file);
    });

});

