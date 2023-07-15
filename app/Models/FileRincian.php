<?php

namespace App\Models;

use App\Models\Keterangan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FileRincian extends Model
{
    use HasFactory;

    protected $table = 'file_rincians';
    protected $guarded = [];

    public function keterangans()
    {
        return $this->belongsTo(Keterangan::class);
    }
}
