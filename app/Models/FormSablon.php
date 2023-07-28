<?php

namespace App\Models;

use App\Models\Instruction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormSablon extends Model
{
    use HasFactory;

    protected $table = 'form_sablons';
    protected $guarded = [];

    public function instruction()
    {
        return $this->belongsTo(Instruction::class);
    }
}
