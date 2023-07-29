<?php

namespace App\Models;

use App\Models\Instruction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormCetak extends Model
{
    use HasFactory;

    protected $table = 'form_cetaks';
    protected $guarded = [];

    public function instruction()
    {
        return $this->belongsTo(Instruction::class);
    }
}