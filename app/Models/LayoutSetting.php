<?php

namespace App\Models;

use App\Models\Keterangan;
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
}
