<?php

namespace App\Models;

use App\Models\Instruction;
use App\Models\UkuranBahanCetakBahan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LayoutBahan extends Model
{
    use HasFactory;

    protected $table = 'layout_bahans';
    protected $guarded = [];

    public function instruction()
    {
        return $this->belongsTo(Instruction::class);
    }

    public function ukuranBahanCetakBahan()
    {
        return $this->hasMany(UkuranBahanCetakBahan::class);
    }
}
