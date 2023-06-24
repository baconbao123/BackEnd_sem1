<?php

use App\Http\Controllers\webController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//person crud
Route::get('/person',[webController::class,'person']);
Route::get('/persondisable',[webController::class,'persondisable']);
Route::post('addperson',[webController::class,'addperson']);
Route::put('updateperson/{id}',[webController::class,'updateperson']);
Route::put('disableperson/{id}',[webController::class,'disableperson']);
Route::put('activeperson/{id}',[webController::class,'activeperson']);
Route::delete('deleteperson/{id}',[webController::class,'deleteperson']);
//life crud
Route::get('/life',[webController::class,'life']);
Route::get('/lifedisable',[webController::class,'lifedisable']);
Route::post('/addlife',[webController::class,'addlife']);
Route::put('/updatelife/{id}',[webController::class,'updatelife']);
Route::put('/deletelife/{id}',[webController::class,'deletelife']);


// prize crud
Route::get('/prize',[webController::class,'prize']);
Route::get('/prizedisable',[webController::class,'prizedisable']);
Route::post('/addprize',[webController::class,'addprize']);
Route::put('/updateprize/{id}',[webController::class,'updateprize']);
Route::delete('/deleteprize/{id}',[webController::class,'deleteprize']);
//person nobel crud
Route::get('/pn',[webController::class,'pn']);
Route::get('/pndisable',[webController::class,'pndisable']);
Route::post('/addpn',[webController::class,'addpn']);
Route::put('/updatepn/{person_id}/{nobel_id}',[webController::class,'updatepn']);
Route::delete('/deletepn/{person_id}/{nobel_id}',[webController::class,'deletepn']);
Route::get('/testpn',[webController::class,'testpn']);
//life and person
Route::get('/personlife ',[webController::class,'personlife']);
//Person and Prize
Route::get('/personprize ',[webController::class,'personprize']);
//nobel and prize
Route::get('/nobelprize ',[webController::class,'nobelprize']);


//api image
Route::get('images/{filename}',function ($filename){
    $path=public_path('img/'.$filename);
    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

//api pdf
Route::get('pdfs/{filename}',function ($filename){
    $path=public_path('pdf/'.$filename);
    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
