<?php

namespace App\Models;

use App\Models\User;
use App\Models\Instruction;
use App\Models\RincianPlate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormPond extends Model
{
    use HasFactory;

    protected $table = 'form_ponds';
    protected $guarded = [];

    public function instruction()
    {
        return $this->belongsTo(Instruction::class);
    }

    // public function rincianPlate()
    // {
    //     return $this->belongsTo(RincianPlate::class);
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
