<?php

namespace App\Models;

use App\Models\Keterangan;
use App\Models\UkuranBahanCetakSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LayoutSetting extends Model
{
    use HasFactory;

    protected $table = 'layout_settings';
    protected $guarded = [];

    public function instruction()
    {
        return $this->belongsTo(Instruction::class);
    }

    public function ukuranBahanCetakSetting()
    {
        return $this->hasMany(UkuranBahanCetakSetting::class);
    }
}
