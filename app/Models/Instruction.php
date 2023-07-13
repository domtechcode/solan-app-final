<?php

namespace App\Models;

use App\Models\Files;
use App\Models\Catatan;
use App\Models\WorkStep;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Instruction extends Model
{
    use HasFactory;

    protected $table = 'instructions';
    protected $guarded = [];

    public function workstep()
    {
        return $this->hasMany(WorkStep::class);
    }

    public function catatan()
    {
        return $this->hasMany(Catatan::class);
    }

    public function fileArsip()
    {
        return $this->hasMany(Files::class);
    }

    public function notificationLog()
    {
        return $this->hasMany(Notification::class);
    }
}
