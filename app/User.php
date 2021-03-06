<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method static find(int $id)
 * @method static where(string $string, int $id)
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFromDateAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
    public function scopeSearch($query,$search){
        return $query->where('name','like','%'.$search.'%')
            ->orWhere('email','like','%'.$search.'%');
    }
}
