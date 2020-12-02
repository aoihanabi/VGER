<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
      * Returns true if the authenticated user's role is admin
      * @return boolean value
      */
    public function isAdmin() {

        return $this->role === 'admin';
    }

    /**
      * Returns true if the authenticated user's role is employee
      * @return boolean value
      */    
    public function isEmployee() {

        return $this->role === 'employee';
    }

    /**
      * Returns true if the authenticated user's role is user
      * @return boolean value
      */
    public function isUser() {

        return $this->role === 'user';
    }

    /**
     * Returns all users with their main information from the DB
     */
    public static function get_all_users() {

        return User::select('id', 'name', 'email', 'phone', 'address', 'role', 'profile_photo_path')->get();
    }
}
