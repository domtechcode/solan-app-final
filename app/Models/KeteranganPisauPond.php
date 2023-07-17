<?php

namespace App\Models;

use App\Models\Keterangan;
use App\Models\Instruction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KeteranganPisauPond extends Model
{
    use HasFactory;

    protected $table = 'keterangan_pisau_ponds';
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
