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


Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('loginProcess');
Route::post('/logout', [LoginController::class, 'logout'])->name('logoutProcess');

Route::get('/dom', 'App\Http\Livewire\Dom\IndexDataRepair')->name('dom');

Route::get('/sender', function () {
    // Logic untuk route ini (jika diperlukan)
    // event(new IndexRenderEvent("refresh"));
    event(new NotificationSent(7, '123123', '123123', 1, 4));
});

Route::group(['middleware' => ['auth']], function () {

    Route::group(['prefix' => 'followup', 'middleware' => ['role:Follow Up']], function () {
        Route::get('/dashboard', 'App\Http\Livewire\FollowUp\Index\IndexDashboard')->name('followUp.dashboard');
        Route::get('/create-instruction', 'App\Http\Livewire\FollowUp\Index\IndexCreateInstruction')->name('followUp.createInstruction');
        Route::get('/create-instruction-kekurangan', 'App\Http\Livewire\FollowUp\Index\IndexCreateInstructionKekurangan')->name('followUp.createInstructionKekurangan');
        Route::get('/edit-instruction/{instructionId}', 'App\Http\Livewire\FollowUp\Index\IndexEditInstruction')->name('followUp.editInstruction');
        Route::get('/update-instruction/{instructionId}', 'App\Http\Livewire\FollowUp\Index\IndexUpdateInstruction')->name('followUp.updateInstruction');
        Route::get('/reorder-instruction/{instructionId}', 'App\Http\Livewire\FollowUp\Index\IndexReorderInstruction')->name('followUp.reorderInstruction');
        Route::get('/create-acc-instruction/{instructionId}', 'App\Http\Livewire\FollowUp\Index\IndexCreateAccInstruction')->name('followUp.createAccInstruction');
        Route::get('/group', 'App\Http\Livewire\FollowUp\Index\IndexGroup')->name('followUp.group');

        Route::get('/pengajuan-barang-personal', 'App\Http\Livewire\FollowUp\Index\IndexPengajuanBarangPersonal')->name('followUp.pengajuanBarangPersonal');
        Route::get('/create-kekurangan-qc/{instructionId}', 'App\Http\Livewire\FollowUp\Index\IndexCreatePengajuanKekuranganQc')->name('followUp.createPengajuanKekuranganQc');
    });

    Route::group(['prefix' => 'stock', 'middleware' => ['role:Stock']], function () {
        Route::get('/dashboard', 'App\Http\Livewire\Stock\Index\IndexDashboard')->name('stock.dashboard');

        Route::get('/pengajuan-barang-personal', 'App\Http\Livewire\Stock\Index\IndexPengajuanBarangPersonal')->name('stock.pengajuanBarangPersonal');
    });

    Route::group(['prefix' => 'hitungbahan', 'middleware' => ['role:Hitung Bahan']], function () {
        Route::get('/dashboard', 'App\Http\Livewire\HitungBahan\Index\IndexDashboard')->name('hitungBahan.dashboard');
        Route::get('/create-form-hitung-bahan/{instructionId}', 'App\Http\Livewire\HitungBahan\Index\IndexCreateFormHitungBahan')->name('hitungBahan.createFormHitungBahan');
        Route::get('/edit-form-hitung-bahan/{instructionId}', 'App\Http\Livewire\HitungBahan\Index\IndexEditFormHitungBahan')->name('hitungBahan.editFormHitungBahan');
        Route::get('/group', 'App\Http\Livewire\HitungBahan\Index\IndexGroup')->name('hitungBahan.group');
        Route::get('/database-hitung-bahan', 'App\Http\Livewire\HitungBahan\Index\IndexDatabaseHitungBahan')->name('hitungBahan.databaseHitungBahan');

        Route::get('/detail-database-hitung-bahan/{instructionId}/{workStepId}', 'App\Http\Livewire\HitungBahan\Index\IndexDetailDatabaseHitungBahan')->name('hitungBahan.detailDatabaseHitungBahan');

        Route::get('/pengajuan-barang-personal', 'App\Http\Livewire\HitungBahan\Index\IndexPengajuanBarangPersonal')->name('hitungBahan.pengajuanBarangPersonal');
        Route::get('/pengajuan-barang-spk', 'App\Http\Livewire\HitungBahan\Index\IndexPengajuanBarangSpk')->name('hitungBahan.pengajuanBarangSpk');
    });

    Route::group(['prefix' => 'rab', 'middleware' => ['role:RAB']], function () {
        Route::get('/dashboard', 'App\Http\Livewire\Rab\Index\IndexDashboard')->name('rab.dashboard');
        Route::get('/create-form-rab/{instructionId}/{workStepId}', 'App\Http\Livewire\Rab\Index\IndexCreateFormRab')->name('rab.createFormRab');
        Route::get('/edit-form-rab/{instructionId}/{workStepId}', 'App\Http\Livewire\Rab\Index\IndexEditFormRab')->name('rab.editFormRab');

        Route::get('/database-rab', 'App\Http\Livewire\Rab\Index\IndexDatabaseRab')->name('rab.databaseRab');

        Route::get('/detail-database-rab/{instructionId}/{workStepId}', 'App\Http\Livewire\Rab\Index\IndexDetailDatabaseRab')->name('rab.detailDatabaseRab');

        Route::get('/pengajuan-barang-personal', 'App\Http\Livewire\Rab\Index\IndexPengajuanBarangPersonal')->name('rab.pengajuanBarangPersonal');
    });

    Route::group(['prefix' => 'jadwal', 'middleware' => ['role:Penjadwalan']], function () {
        Route::get('/dashboard', 'App\Http\Livewire\Penjadwalan\Index\IndexDashboard')->name('jadwal.dashboard');
        Route::get('/group', 'App\Http\Livewire\Penjadwalan\Index\IndexGroup')->name('jadwal.group');
        Route::get('/form-work-step/{instructionId}/{workStepId}', 'App\Http\Livewire\Penjadwalan\Index\IndexWorkStep')->name('jadwal.indexWorkStep');

        Route::get('/pengajuan-barang-personal', 'App\Http\Livewire\Penjadwalan\Index\IndexPengajuanBarangPersonal')->name('jadwal.pengajuanBarangPersonal');
        Route::get('/pengajuan-barang-spk', 'App\Http\Livewire\Penjadwalan\Index\IndexPengajuanBarangSpk')->name('jadwal.pengajuanBarangSpk');
    });

    Route::group(['prefix' => 'operator', 'middleware' => ['role:Operator']], function () {
        Route::get('/dashboard', 'App\Http\Livewire\Operator\Index\IndexDashboard')->name('operator.dashboard');
        Route::get('/form-work-step/{instructionId}/{workStepId}', 'App\Http\Livewire\Operator\Index\IndexWorkStep')->name('indexWorkStep');

        Route::get('/pengajuan-barang-personal', 'App\Http\Livewire\Operator\Index\IndexPengajuanBarangPersonal')->name('operator.pengajuanBarangPersonal');
        Route::get('/pengajuan-barang-spk', 'App\Http\Livewire\Operator\Index\IndexPengajuanBarangSpk')->name('operator.pengajuanBarangSpk');

        Route::get('/database-file-layout-setting', 'App\Http\Livewire\Operator\Index\IndexDatabaseFileLayoutSetting')->name('operator.databaseFileLayoutSetting');
        Route::get('/database-file-film-setting', 'App\Http\Livewire\Operator\Index\IndexDatabaseFileFilmSetting')->name('operator.databaseFileFilmSetting');

        Route::get('/database-plate', 'App\Http\Livewire\Operator\Index\IndexDatabasePlate')->name('operator.databasePlate');

        Route::get('/details-workstep/{instructionId}/{workStepId}', 'App\Http\Livewire\Operator\Index\IndexDetailWorkStep')->name('operator.indexDetailWorkStep');
    });

    Route::group(['prefix' => 'accounting', 'middleware' => ['role:Accounting']], function () {
        Route::get('/dashboard', 'App\Http\Livewire\Accounting\Index\IndexDashboard')->name('accounting.dashboard');
        Route::get('/data-customer', 'App\Http\Livewire\Accounting\Index\IndexCustomer')->name('accounting.dataCustomer');
        Route::get('/form-work-step/{instructionId}/{workStepId}', 'App\Http\Livewire\Accounting\Index\IndexWorkStep')->name('accounting.indexWorkStep');

        Route::get('/pengajuan-barang-personal', 'App\Http\Livewire\Accounting\Index\IndexPengajuanBarangPersonal')->name('accounting.pengajuanBarangPersonal');
    });

    Route::group(['prefix' => 'purchase', 'middleware' => ['role:Purchase']], function () {
        Route::get('/dashboard', 'App\Http\Livewire\Purchase\Index\IndexDashboard')->name('purchase.dashboard');
        Route::get('/form-work-step/{instructionId}/{workStepId}', 'App\Http\Livewire\Purchase\Index\IndexWorkStep')->name('purchase.indexWorkStep');
        Route::get('/pengajuan-barang-personal', 'App\Http\Livewire\Purchase\Index\IndexPengajuanBarangPersonal')->name('purchase.pengajuanBarangPersonal');
    });

    Route::group(['prefix' => 'admin', 'middleware' => ['role:Admin']], function () {
        Route::get('/dashboard', 'App\Http\Livewire\Admin\Index\IndexDashboard')->name('admin.dashboard');
        Route::get('/data-user', 'App\Http\Livewire\Admin\Index\IndexDataUser')->name('admin.dataUser');
        Route::get('/data-langkah-kerja', 'App\Http\Livewire\Admin\Index\IndexDataLangkahKerja')->name('admin.dataLangkahKerja');
        Route::get('/data-machine', 'App\Http\Livewire\Admin\Index\IndexDataMachine')->name('admin.dataMachine');
        Route::get('/data-driver', 'App\Http\Livewire\Admin\Index\IndexDataDriver')->name('admin.dataDriver');

        Route::get('/details-workstep/{instructionId}/{workStepId}', 'App\Http\Livewire\Admin\Index\IndexDetailWorkStep')->name('admin.indexDetailWorkStep');
    });
    
});