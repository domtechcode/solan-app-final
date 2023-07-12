<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Livewire\FollowUp\IndexDashboard;
use App\Http\Livewire\FollowUp\IndexEditInstruction;
use App\Http\Livewire\FollowUp\IndexCreateInstruction;
use App\Http\Livewire\FollowUp\IndexUpdateInstruction;

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

Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('loginProcess');
Route::post('logout', [LoginController::class, 'logout'])->name('logoutProcess');

Route::get('/dashboard', IndexDashboard::class)->name('dashboard');
Route::get('/create-instruction', IndexCreateInstruction::class)->name('createInstruction');
Route::get('/edit-instruction/{instructionId}', IndexEditInstruction::class)->name('editInstruction');
Route::get('/update-instruction/{instructionId}', IndexUpdateInstruction::class)->name('updateInstruction');

Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix' => 'followup', 'middleware' => ['role:followup']], function () {

    });

});