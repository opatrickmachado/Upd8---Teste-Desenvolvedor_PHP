<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('clientes', [ApiController::class, 'getAllClientes']);
Route::get('estados', [ApiController::class, 'getAllEstados']);
Route::get('cidades', [ApiController::class, 'getAllCidades']);

Route::get('cliente/{id}', [ApiController::class, 'getCliente']);
Route::get('estado/{id}', [ApiController::class, 'getEstado']);
Route::get('cidade/{id}', [ApiController::class, 'getCidade']);
Route::get('listar-cidades/{id}', [ApiController::class, 'getAllCidadeEstado']);
Route::post('listar-clientes', [ApiController::class, 'getSearchClientes']);

Route::post('cliente', [ApiController::class, 'createCliente']);
Route::put('cliente/{id}', [ApiController::class, 'updateCliente']);
Route::delete('cliente/{id}', [ApiController::class, 'deleteCliente']);
