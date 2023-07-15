<?php

namespace App\Models;

use App\Models\Keterangan;
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
}
