<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CatatanPengajuan extends Model
{
    use HasFactory;

    protected $table = 'catatan_pengajuans';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
