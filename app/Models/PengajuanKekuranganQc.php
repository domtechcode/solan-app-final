<?php

namespace App\Models;

use App\Models\Instruction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengajuanKekuranganQc extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_kekurangan_qcs';
    protected $guarded = [];
    
    public function instruction()
    {
        return $this->belongsTo(Instruction::class);
    }
}
