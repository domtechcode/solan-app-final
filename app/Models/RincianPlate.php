<?php

namespace App\Models;

use App\Models\FormFoil;
use App\Models\FormPond;
use App\Models\FormCetak;
use App\Models\Keterangan;
use App\Models\WarnaPlate;
use App\Models\Instruction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RincianPlate extends Model
{
    use HasFactory;

    protected $table = 'rincian_plates';
    protected $guarded = [];

    public function keterangans()
    {
        return $this->belongsTo(Keterangan::class);
    }

    public function instruction()
    {
        return $this->belongsTo(Instruction::class);
    }

    public function warnaPlate()
    {
        return $this->hasMany(WarnaPlate::class);
    }

    public function formCetak()
    {
        return $this->hasMany(FormCetak::class);
    }

    public function formFoil()
    {
        return $this->hasMany(FormFoil::class);
    }

    public function formPond()
    {
        return $this->hasMany(FormPond::class);
    }
}
