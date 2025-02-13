<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\MdfController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/auth', [AuthController::class, 'auth']);

Route::post('/auth/token', [AuthController::class, 'authByToken']);

//Routes Clients
Route::get('/clients',[ClientController::class,'index']) ;
Route::post('/clients',[ClientController::class,'store']) ;
Route::get('/clients/{CodeClient}',[ClientController::class,'show']) ;
Route::put('/clients/{CodeClient}',[ClientController::class,'update']) ;
Route::delete('/clients/{CodeClient}',[ClientController::class,'destroy']) ;
Route::put('/clients/restaurer/{CodeClient}',[ClientController::class,'restore']) ;
Route::get('/deletedClients',[ClientController::class,'getDeletedClients']) ;

//Routes MDF :
Route::get('/mdfs',[MdfController::class,'index']) ;
Route::post('/mdf',[MdfController::class,'store']) ;
Route::get('/mdfs/{NumSerie}',[MdfController::class,'show']) ;
Route::put('/mdf/{NumSerie}',[MdfController::class,'update']) ;
Route::delete('/mdf/{NumSerie}',[MdfController::class,'destroy']) ;
Route::put('/mdf/restaurer/{NumSerie}',[MdfController::class,'restore']) ;
Route::get('/deletedMdfs',[MdfController::class,'getDeletedMdf']) ;
Route::put('/mdfs/update/{NumSerie}', [MdfController::class, 'updateEtat']);

// Routes Contrats :
Route::get('/contrats',[ContratController::class,'index']) ;
Route::post('/contrats', [ContratController::class,'store']);
Route::get('/contrats/{NumContrat}',[ContratController::class,'show']) ;
Route::put('/contrats/{NumContrat}',[ContratController::class,'update']) ;
Route::delete('/contrats/{NumContrat}',[ContratController::class,'destroy']) ;
Route::put('/contrats/resilier/{NumContrat}', [ContratController::class, 'resilier']);
Route::put('/contrats/restaurer/{NumContrat}', [ContratController::class, 'restaurer']);
Route::put('/ContratsEchange', [ContratController::class, 'echangerMdf']);
Route::post('/transfertMdf', [ContratController::class, 'transfertMdf']);
Route::get('/resilies', [ContratController::class, 'getResilies']);



Route::get('/comptes/{id}',[UserController::class,'show']) ;



