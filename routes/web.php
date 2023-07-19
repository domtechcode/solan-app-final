<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\FollowUp\Index\IndexGroup;
use App\Http\Controllers\Auth\LoginContr\LoginController;
use App\Http\Livewire\FollowUp\Index\IndexEditInstruction;
use App\Http\Livewire\HitungBahan\IndexEditFormHitungBahan;
use App\Http\Livewire\FollowUp\Index\IndexCreateInstruction;
use App\Http\Livewire\FollowUp\Index\IndexUpdateInstruction;
use App\Http\Livewire\HitungBahan\IndexCreateFormHitungBahan;

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

// Route::get('/create-form-hitung-bahan/{instructionId}', IndexCreateFormHitungBahan::class)->name('hitungBahan.createFormHitungBahan');
// Route::get('/edit-form-hitung-bahan/{instructionId}', IndexEditFormHitungBahan::class)->name('hitungBahan.editFormHitungBahan');

// Route::get('/create-form-rab/{instructionId}', IndexCreateFormRab::class)->name('rab.createFormRab');

// Route::get('/group', IndexGroup::class);

Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix' => 'followup', 'middleware' => ['role:Follow Up']], function () {
        Route::get('/dashboard', 'App\Http\Livewire\FollowUp\Index\IndexDashboard')->name('followUp.dashboard');
        Route::get('/create-instruction', 'App\Http\Livewire\FollowUp\Index\IndexCreateInstruction')->name('followUp.createInstruction');
        Route::get('/edit-instruction/{instructionId}', 'App\Http\Livewire\FollowUp\Index\IndexEditInstruction')->name('followUp.editInstruction');
        Route::get('/update-instruction/{instructionId}', 'App\Http\Livewire\FollowUp\Index\IndexUpdateInstruction')->name('followUp.updateInstruction');
        Route::get('/group', IndexGroup::class)->name('group');

    });

    Route::group(['prefix' => 'stock', 'middleware' => ['role:Stock']], function () {
        Route::get('/dashboard', 'App\Http\Livewire\Stock\Index\IndexDashboard')->name('stock.dashboard');

    });

});