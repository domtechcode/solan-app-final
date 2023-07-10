<?php

namespace App\Models;

use App\Models\Files;
use App\Models\Catatan;
use Laravel\Sanctum\HasApiTokens;
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
    protected $fillable = [
        'name',
        'username',
        'role',
    ];

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

    public function file()
    {
        return $this->hasMany(Files::class);
    }
}
