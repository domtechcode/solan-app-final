<?php

namespace App\Models;

use App\Models\FileRincian;
use App\Models\Instruction;
use App\Models\RincianPlate;
use App\Models\LayoutSetting;
use App\Models\KeteranganPlate;
use App\Models\KeteranganPisauPond;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Keterangan extends Model
{
    use HasFactory;

    protected $table = 'keterangans';
    protected $guarded = [];

    public function instruction()
    {
        return $this->belongsTo(Instruction::class);
    }

    public function rincianPlate()
    {
        return $this->hasMany(RincianPlate::class);
    }

    public function keteranganPlate()
    {
        return $this->hasMany(KeteranganPlate::class);
    }

    public function keteranganPisauPond()
    {
        return $this->hasMany(KeteranganPisauPond::class);
    }

    public function fileRincian()
    {
        return $this->hasMany(FileRincian::class);
    }
}
