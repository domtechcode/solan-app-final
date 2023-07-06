<?php

namespace App\Models;

use App\Models\WorkStep;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkStepList extends Model
{
    use HasFactory;

    protected $table = 'work_step_lists';
    protected $guarded = [];

    public function workstep()
    {
        return $this->hasMany(WorkStep::class);
    }
}
