<?php

namespace App\Models;

use App\Models\WorkStep;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory;

    protected $table = 'statuses';
    protected $guarded = [];

    public function workstep()
    {
        return $this->hasMany(WorkStep::class);
    }
}
