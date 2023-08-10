<?php

namespace App\Models;

use App\Models\LayoutSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UkuranBahanCetakSetting extends Model
{
    use HasFactory;

    protected $table = 'ukuran_bahan_cetak_settings';
    protected $guarded = [];

    public function layoutSetting()
    {
        return $this->belongsTo(LayoutSetting::class);
    }
}
