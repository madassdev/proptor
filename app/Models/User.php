<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'first_name', 'last_name', 'email', 'password', 'mobile', 'status', 
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

    public function agent()
    {
        return $this->hasOne(Agent::class);
    }
    
    public static function resolveFirstAndLastName(String $full_name)
    {
        $split_name = explode(" ", $full_name, 2);
        $names['first_name'] = $split_name[0];
        $names['last_name'] = array_key_exists(1, $split_name) ? $split_name[1]:null;
        return $names;
    }
}
