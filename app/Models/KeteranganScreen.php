<?php

namespace App\Models;

use App\Models\Keterangan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KeteranganScreen extends Model
{
    use HasFactory;

    protected $table = 'keterangan_screens';
    protected $guarded = [];

    public function keterangans()
    {
        return $this->belongsTo(Keterangan::class);
    }
}
