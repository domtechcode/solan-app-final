<?php

namespace App\Models;

use App\Models\User;
use App\Models\Status;
use App\Models\Instruction;
use App\Models\WorkStepList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengajuanBarangSpk extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_barang_spks';
    protected $guarded = [];

    public function instruction()
    {
        return $this->belongsTo(Instruction::class);
    }

    public function workStepList()
    {
        return $this->belongsTo(WorkStepList::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
