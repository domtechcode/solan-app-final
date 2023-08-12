<?php

namespace App\Models;

use App\Models\Instruction;
use App\Models\RincianPlate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormFoil extends Model
{
    use HasFactory;

    protected $table = 'form_foils';
    protected $guarded = [];

    public function instruction()
    {
        return $this->belongsTo(Instruction::class);
    }

    public function rincianPlate()
    {
        return $this->belongsTo(RincianPlate::class);
    }
}
