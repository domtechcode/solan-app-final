<?php

namespace App\Models;

use App\Models\Files;
use App\Models\Catatan;
use App\Models\FormLem;
use App\Models\FormRab;
use App\Models\FormFoil;
use App\Models\FormPond;
use App\Models\WorkStep;
use App\Models\FormCetak;
use App\Models\FormPlate;
use App\Models\FormMaklun;
use App\Models\FormSablon;
use App\Models\FormSample;
use App\Models\FormSortir;
use App\Models\Keterangan;
use App\Models\WarnaPlate;
use App\Models\FileRincian;
use App\Models\FileSetting;
use App\Models\LayoutBahan;
use App\Models\Notification;
use App\Models\RincianPlate;
use App\Models\FormFinishing;
use App\Models\FormQcPacking;
use App\Models\LayoutSetting;
use App\Models\RincianScreen;
use App\Models\FormCetakLabel;
use App\Models\FormPengiriman;
use App\Models\FormPotongJadi;
use App\Models\KeteranganFoil;
use App\Models\KeteranganLabel;
use App\Models\KeteranganPlate;
use App\Models\FormLipatPinggir;
use App\Models\KeteranganScreen;
use App\Models\FormOtherWorkStep;
use App\Models\PengajuanBarangSpk;
use App\Models\FormPengajuanMaklun;
use App\Models\KeteranganPisauPond;
use App\Models\FormPenerimaanMaklun;
use Illuminate\Database\Eloquent\Model;
use App\Models\KeteranganMatressEmbossDeboss;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Instruction extends Model
{
    use HasFactory;

    protected $table = 'instructions';
    protected $guarded = [];

    public function workStep()
    {
        return $this->hasMany(WorkStep::class);
    }

    public function catatan()
    {
        return $this->hasMany(Catatan::class);
    }

    public function fileArsip()
    {
        return $this->hasMany(Files::class);
    }

    public function fileSetting()
    {
        return $this->hasMany(FileSetting::class);
    }

    public function notificationLog()
    {
        return $this->hasMany(Notification::class);
    }

    public function keterangans()
    {
        return $this->hasMany(Keterangan::class);
    }

    public function layoutSetting()
    {
        return $this->hasMany(LayoutSetting::class);
    }

    public function layoutBahan()
    {
        return $this->hasMany(LayoutBahan::class);
    }

    public function fileRincian()
    {
        return $this->hasMany(FileRincian::class);
    }

    public function keteranganPisauPond()
    {
        return $this->hasMany(KeteranganPisauPond::class);
    }

    public function keteranganPlate()
    {
        return $this->hasMany(KeteranganPlate::class);
    }

    public function keteranganScreen()
    {
        return $this->hasMany(KeteranganScreen::class);
    }

    public function keteranganFoil()
    {
        return $this->hasMany(KeteranganFoil::class);
    }

    public function keteranganMatress()
    {
        return $this->hasMany(KeteranganMatressEmbossDeboss::class);
    }

    public function rincianPlate()
    {
        return $this->hasMany(RincianPlate::class);
    }

    public function rincianScreen()
    {
        return $this->hasMany(RincianScreen::class);
    }

    public function keteranganLabel()
    {
        return $this->hasMany(KeteranganLabel::class);
    }

    public function formRab()
    {
        return $this->hasMany(FormRab::class);
    }

    public function warnaPlate()
    {
        return $this->hasMany(WarnaPlate::class);
    }

    public function formPlate()
    {
        return $this->hasMany(FormPlate::class);
    }

    public function formCetak()
    {
        return $this->hasMany(FormCetak::class);
    }

    public function formSablon()
    {
        return $this->hasMany(FormSablon::class);
    }

    public function formPond()
    {
        return $this->hasMany(FormPond::class);
    }

    public function formOtherWorkStep()
    {
        return $this->hasMany(FormOtherWorkStep::class);
    }

    public function formLem()
    {
        return $this->hasMany(FormLem::class);
    }

    public function formCetakLabel()
    {
        return $this->hasMany(FormCetakLabel::class);
    }

    public function formFoil()
    {
        return $this->hasMany(FormFoil::class);
    }

    public function formQcPacking()
    {
        return $this->hasMany(FormQcPacking::class);
    }

    public function formPengiriman()
    {
        return $this->hasMany(FormPengiriman::class);
    }

    public function formFinishing()
    {
        return $this->hasMany(FormFinishing::class);
    }

    public function formPengajuanMaklun()
    {
        return $this->hasMany(FormPengajuanMaklun::class);
    }

    public function formPenerimaanMaklun()
    {
        return $this->hasMany(FormPenerimaanMaklun::class);
    }

    public function formPotongJadi()
    {
        return $this->hasMany(FormPotongJadi::class);
    }

    public function formSortir()
    {
        return $this->hasMany(FormSortir::class);
    }

    public function formLipatPinggir()
    {
        return $this->hasMany(FormLipatPinggir::class);
    }

    public function pengajuanBarangSpk()
    {
        return $this->hasMany(PengajuanBarangSpk::class);
    }
}
