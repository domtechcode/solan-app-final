<?php

namespace App\Models;

use App\Models\Files;
use App\Models\Catatan;
use App\Models\FormRab;
use App\Models\WorkStep;
use App\Models\CatatanPengajuan;
use Laravel\Sanctum\HasApiTokens;
use App\Models\PengajuanBarangSpk;
use App\Models\PengajuanBarangPersonal;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    // protected $guarded = [];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public static function search($search)
    // {
    //     return empty($search) ? static::query()
    //         : static::query()->where('id', 'like', '%'.$search.'%')
    //                 ->orwhere('name', 'like', '%'.$search.'%')
    //                 ->orwhere('role', 'like', '%'.$search.'%');
    // }

    public function catatan()
    {
        return $this->hasMany(Catatan::class);
    }

    public function catatanPengajuan()
    {
        return $this->hasMany(CatatanPengajuan::class);
    }

    public function file()
    {
        return $this->hasMany(Files::class);
    }

    public function workstep()
    {
        return $this->hasMany(WorkStep::class);
    }

    public function notificationLog()
    {
        return $this->hasMany(Notification::class);
    }

    public function formRab()
    {
        return $this->hasMany(FormRab::class);
    }

    public function pengajuanBarangSpk()
    {
        return $this->hasMany(PengajuanBarangSpk::class);
    }

    public function pengajuanBarangPersonal()
    {
        return $this->hasMany(PengajuanBarangPersonal::class);
    }
}
