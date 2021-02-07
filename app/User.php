<?php

namespace App;

use App\Helpers\StringHelper;
use App\Models\Employee;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $phone_number
 * @property string $remember_token
 * @property string $phone_number_slug
 * @property Employee $employee
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
        'name',
        'email',
        'password',
        'phone_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'phone_number_slug',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function setPhoneNumberAttribute($value)
    {
        $this->attributes['phone_number'] = $value;
        $this->attributes['phone_number_slug'] = StringHelper::detectPhoneNumber($value);
    }

    public function userRoles()
    {
        return $this->hasMany(UserRole::class);
    }

    public function hasRole(string $slug)
    {
        return (bool) $this->getRoleBuilderBySlug($slug)->first();
    }

    public function deleteRole(string $slug)
    {
        return (bool) $this->getRoleBuilderBySlug($slug)->delete();
    }

    public function getRoleBuilderBySlug(string $slug)
    {
        return $this->userRoles()->whereHas('role', function ($query) use ($slug) {
            $query->where('slug', $slug);
        });
    }

    public function addRole(string $slug)
    {
        if ($this->hasRole($slug)) {
            return;
        }

        return $this->userRoles()->create([
            'role_id' => Role::getBySlug($slug)->id,
        ]);
    }
}
