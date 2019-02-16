<?php

namespace App\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * User.
 *
 * @property string $name
 * @property string $email
 * @property string $password
 * @property-read bool   $is_admin
 * @property-read string $avatar_url Gets the avatar image URL.
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRoles;

    /**
     * @var string
     */
    const DEFAULT_AVATAR_URL = '/svg/default-avatar.svg';

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

    protected $appends = [
        'is_admin',
        'avatar_url',
    ];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


    // [ Mutators ] ############################################################

    /**
     * $password Setter
     *
     * @param string $value
     */
    public function setPasswordAttribute(string $value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * $is_admin getter
     *
     * @return bool
     */
    public function getIsAdminAttribute() : bool
    {
        return $this->hasRole('admin');
    }

    /**
     * $avatar_url getter
     *
     * @return string
     */
    public function getAvatarUrlAttribute() : string
    {
        return static::DEFAULT_AVATAR_URL;
    }
}
