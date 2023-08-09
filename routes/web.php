<?php

use App\Events\IndexRenderEvent;
use App\Events\NotificationSent;
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


Route::get('/', [LoginController::class, 'showLoginForm'])->name('login')->middleware('redirectIfAuthenticated');
Route::post('/login', [LoginController::class, 'login'])->name('loginProcess');
Route::post('/logout', [LoginController::class, 'logout'])->name('logoutProcess');

// Route::get('/sender', function () {
//     // Logic untuk route ini (jika diperlukan)
//     event(new NotificationSent(2, "asdasdasd", "asdasd", "1", 4));
// });

Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix' => 'followup', 'middleware' => ['role:Follow Up']], function () {
        Route::get('/dashboard', 'App\Http\Livewire\FollowUp\Index\IndexDashboard')->name('followUp.dashboard');
        Route::get('/create-instruction', 'App\Http\Livewire\FollowUp\Index\IndexCreateInstruction')->name('followUp.createInstruction');
        Route::get('/create-instruction-kekurangan', 'App\Http\Livewire\FollowUp\Index\IndexCreateInstructionKekurangan')->name('followUp.createInstructionKekurangan');
        Route::get('/edit-instruction/{instructionId}', 'App\Http\Livewire\FollowUp\Index\IndexEditInstruction')->name('followUp.editInstruction');
        Route::get('/update-instruction/{instructionId}', 'App\Http\Livewire\FollowUp\Index\IndexUpdateInstruction')->name('followUp.updateInstruction');
        Route::get('/reorder-instruction/{instructionId}', 'App\Http\Livewire\FollowUp\Index\IndexReorderInstruction')->name('followUp.reorderInstruction');
        Route::get('/group', 'App\Http\Livewire\FollowUp\Index\IndexGroup')->name('followUp.group');
    });

    Route::group(['prefix' => 'stock', 'middleware' => ['role:Stock']], function () {
        Route::get('/dashboard', 'App\Http\Livewire\Stock\Index\IndexDashboard')->name('stock.dashboard');
    });

    Route::group(['prefix' => 'hitungbahan', 'middleware' => ['role:Hitung Bahan']], function () {
        Route::get('/dashboard', 'App\Http\Livewire\HitungBahan\Index\IndexDashboard')->name('hitungBahan.dashboard');
        Route::get('/create-form-hitung-bahan/{instructionId}', 'App\Http\Livewire\HitungBahan\Index\IndexCreateFormHitungBahan')->name('hitungBahan.createFormHitungBahan');
        Route::get('/edit-form-hitung-bahan/{instructionId}', 'App\Http\Livewire\HitungBahan\Index\IndexEditFormHitungBahan')->name('hitungBahan.editFormHitungBahan');
        Route::get('/group', 'App\Http\Livewire\HitungBahan\Index\IndexGroup')->name('hitungBahan.group');
    });

    Route::group(['prefix' => 'rab', 'middleware' => ['role:RAB']], function () {
        Route::get('/dashboard', 'App\Http\Livewire\Rab\Index\IndexDashboard')->name('rab.dashboard');
        Route::get('/create-form-rab/{instructionId}/{workStepId}', 'App\Http\Livewire\Rab\Index\IndexCreateFormRab')->name('rab.createFormRab');
        Route::get('/edit-form-rab/{instructionId}/{workStepId}', 'App\Http\Livewire\Rab\Index\IndexEditFormRab')->name('rab.editFormRab');
    });

    Route::group(['prefix' => 'jadwal', 'middleware' => ['role:Penjadwalan']], function () {
        Route::get('/dashboard', 'App\Http\Livewire\Penjadwalan\Index\IndexDashboard')->name('jadwal.dashboard');
        Route::get('/group', 'App\Http\Livewire\Penjadwalan\Index\IndexGroup')->name('jadwal.group');
        Route::get('/form-work-step/{instructionId}/{workStepId}', 'App\Http\Livewire\Penjadwalan\Index\IndexWorkStep')->name('jadwal.indexWorkStep');
    });

    Route::group(['prefix' => 'operator', 'middleware' => ['role:Operator']], function () {
        Route::get('/dashboard', 'App\Http\Livewire\Operator\Index\IndexDashboard')->name('operator.dashboard');
        Route::get('/form-work-step/{instructionId}/{workStepId}', 'App\Http\Livewire\Operator\Index\IndexWorkStep')->name('indexWorkStep');
    });

    Route::group(['prefix' => 'accounting', 'middleware' => ['role:Accounting']], function () {
        Route::get('/dashboard', 'App\Http\Livewire\Accounting\Index\IndexDashboard')->name('accounting.dashboard');
        Route::get('/data-customer', 'App\Http\Livewire\Accounting\Index\IndexCustomer')->name('accounting.dataCustomer');
        Route::get('/form-work-step/{instructionId}/{workStepId}', 'App\Http\Livewire\Accounting\Index\IndexWorkStep')->name('accounting.indexWorkStep');
    });

    Route::group(['prefix' => 'purchase', 'middleware' => ['role:Purchase']], function () {
        Route::get('/dashboard', 'App\Http\Livewire\Purchase\Index\IndexDashboard')->name('purchase.dashboard');
    });
    
});