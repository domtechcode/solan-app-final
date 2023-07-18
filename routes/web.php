<?php

use App\Events\HelloEvent;
use App\Events\NotificationSent;
use App\Http\Livewire\ExcelViewer;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\FollowUp\IndexGroup;
use App\Http\Livewire\Rab\IndexCreateFormRab;
use App\Http\Livewire\FollowUp\IndexDashboard;
use App\Http\Livewire\FollowUp\IndexEditInstruction;
use App\Http\Livewire\FollowUp\IndexCreateInstruction;
use App\Http\Livewire\FollowUp\IndexUpdateInstruction;
use App\Http\Controllers\Auth\LoginContr\LoginController;
use App\Http\Livewire\HitungBahan\IndexEditFormHitungBahan;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/sender', function () {
//     broadcast(new NotificationSent(date('Y-m-d H:i:s'). "Halo"));
// });

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('loginProcess');
Route::post('logout', [LoginController::class, 'logout'])->name('logoutProcess');

Route::get('/create-form-hitung-bahan/{instructionId}', IndexCreateFormHitungBahan::class)->name('hitungBahan.createFormHitungBahan');
Route::get('/edit-form-hitung-bahan/{instructionId}', IndexEditFormHitungBahan::class)->name('hitungBahan.editFormHitungBahan');

Route::get('/create-form-rab/{instructionId}', IndexCreateFormRab::class)->name('rab.createFormRab');

Route::get('/group', IndexGroup::class);

Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix' => 'followup', 'middleware' => ['role:Follow Up']], function () {
        Route::get('/dashboard', IndexDashboard::class)->name('followUp.dashboard');
        Route::get('/create-instruction', IndexCreateInstruction::class)->name('createInstruction');
        Route::get('/edit-instruction/{instructionId}', IndexEditInstruction::class)->name('editInstruction');
        Route::get('/update-instruction/{instructionId}', IndexUpdateInstruction::class)->name('updateInstruction');
    });

});