<?php

namespace App\Models;

use App\Models\Instruction;
use App\Models\RincianPlate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WarnaPlate extends Model
{
    use HasFactory;

    protected $table = 'warna_plates';
    protected $guarded = [];

    public function rincianPlate()
    {
        return $this->belongsTo(RincianPlate::class);
    }

    public function instruction()
    {
        return $this->belongsTo(Instruction::class);
    }
}
