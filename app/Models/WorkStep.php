<?php

namespace App\Models;

use App\Models\Job;
use App\Models\User;
use App\Models\Status;
use App\Models\Machine;
use App\Models\Instruction;
use App\Models\WorkStepList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkStep extends Model
{
    use HasFactory;

    protected $table = 'work_steps';
    protected $guarded = [];

    public function instruction()
    {
        return $this->belongsTo(Instruction::class);
    }

    public function workStepList()
    {
        return $this->belongsTo(WorkStepList::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $searchTerm)
    {
        $searchTerm = "%$searchTerm%";
        $query->where(function ($query) use ($searchTerm) {
            $query->orWhereHas('instruction', function ($query) use ($searchTerm) {
                $query->where('spk_number', 'like', $searchTerm)
                ->orWhere('spk_type', 'like', $searchTerm)
                ->orWhere('customer_name', 'like', $searchTerm)
                ->orWhere('order_name', 'like', $searchTerm)
                ->orWhere('customer_number', 'like', $searchTerm)
                ->orWhere('code_style', 'like', $searchTerm)
                ->orWhere('shipping_date', 'like', $searchTerm)
                ->orWhere('ukuran_barang', 'like', $searchTerm)
                ->orWhere('spk_number_fsc', 'like', $searchTerm);
            })
            ->orWhereHas('job', function ($query) use ($searchTerm) {
                $query->where('desc_job', 'like', $searchTerm);
            })
            ->orWhereHas('status', function ($query) use ($searchTerm) {
                $query->where('desc_status', 'like', $searchTerm);
            });
        });
    }

}
