<?php

namespace App\Models;

use App\Models\LayoutBahan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UkuranBahanCetakBahan extends Model
{
    use HasFactory;

    protected $table = 'ukuran_bahan_cetak_bahans';
    protected $guarded = [];

    public function layoutBahan()
    {
        return $this->belongsTo(LayoutBahan::class);
    }
}
