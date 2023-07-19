<?php

namespace App\Models;

use App\Models\Files;
use App\Models\Catatan;
use App\Models\WorkStep;
use App\Models\Keterangan;
use App\Models\FileRincian;
use App\Models\LayoutBahan;
use App\Models\Notification;
use App\Models\RincianPlate;
use App\Models\LayoutSetting;
use App\Models\RincianScreen;
use App\Models\KeteranganPlate;
use App\Models\KeteranganScreen;
use App\Models\KeteranganPisauPond;
use Illuminate\Database\Eloquent\Model;
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
}
