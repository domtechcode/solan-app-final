<?php

namespace App\Models;

use App\Models\Keterangan;
use App\Models\Instruction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KeteranganPlate extends Model
{
    use HasFactory;

    protected $table = 'keterangan_plates';
    protected $guarded = [];

    public function keterangans()
    {
        return $this->belongsTo(Keterangan::class);
    }

    public function instruction()
    {
        return $this->belongsTo(Instruction::class);
    }
}
