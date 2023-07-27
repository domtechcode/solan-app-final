<?php

namespace App\Models;

use App\Models\Instruction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FileSetting extends Model
{
    use HasFactory;

    protected $table = 'file_settings';
    protected $guarded = [];
    
    public function instruction()
    {
        return $this->belongsTo(Instruction::class);
    }
}
