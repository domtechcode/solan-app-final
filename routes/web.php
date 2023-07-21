<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\FollowUp\Index\IndexGroup;
use App\Http\Controllers\Auth\LoginContr\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('loginProcess');
Route::post('logout', [LoginController::class, 'logout'])->name('logoutProcess');


Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix' => 'followup', 'middleware' => ['role:Follow Up']], function () {
        Route::get('/dashboard', 'App\Http\Livewire\FollowUp\Index\IndexDashboard')->name('followUp.dashboard');
        Route::get('/create-instruction', 'App\Http\Livewire\FollowUp\Index\IndexCreateInstruction')->name('followUp.createInstruction');
        Route::get('/create-instruction-kekurangan', 'App\Http\Livewire\FollowUp\Index\IndexCreateInstructionKekurangan')->name('followUp.createInstructionKekurangan');
        Route::get('/edit-instruction/{instructionId}', 'App\Http\Livewire\FollowUp\Index\IndexEditInstruction')->name('followUp.editInstruction');
        Route::get('/update-instruction/{instructionId}', 'App\Http\Livewire\FollowUp\Index\IndexUpdateInstruction')->name('followUp.updateInstruction');
        Route::get('/reorder-instruction/{instructionId}', 'App\Http\Livewire\FollowUp\Index\IndexReorderInstruction')->name('followUp.reorderInstruction');
        Route::get('/group', 'App\Http\Livewire\FollowUp\Index\IndexGroup')->name('group');
    });

    Route::group(['prefix' => 'stock', 'middleware' => ['role:Stock']], function () {
        Route::get('/dashboard', 'App\Http\Livewire\Stock\Index\IndexDashboard')->name('stock.dashboard');
    });

    Route::group(['prefix' => 'hitungbahan', 'middleware' => ['role:Hitung Bahan']], function () {
        Route::get('/dashboard', 'App\Http\Livewire\HitungBahan\Index\IndexDashboard')->name('hitungBahan.dashboard');
        Route::get('/create-form-hitung-bahan/{instructionId}', 'App\Http\Livewire\HitungBahan\Index\IndexCreateFormHitungBahan')->name('hitungBahan.createFormHitungBahan');
        Route::get('/edit-form-hitung-bahan/{instructionId}', 'App\Http\Livewire\HitungBahan\Index\IndexEditFormHitungBahan')->name('hitungBahan.editFormHitungBahan');
        Route::get('/group', 'App\Http\Livewire\HitungBahan\Index\IndexGroup')->name('group');
    });

});