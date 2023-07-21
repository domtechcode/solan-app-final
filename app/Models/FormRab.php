<?php

namespace App\Models;

use App\Models\User;
use App\Models\Instruction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormRab extends Model
{
    use HasFactory;

    protected $table = 'form_rabs';
    protected $guarded = [];

    public function instruction()
    {
        return $this->belongsTo(Instruction::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
