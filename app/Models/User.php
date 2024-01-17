<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_EDITOR = 'editor';
    public const ROLE_REVIEWER = 'reviewer';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "mst_users";

    protected $fillable = [
        'name',
        'email',
        'password',
        'group_role',
        'remember_token',
        'verify_email',
        'is_active',
        'is_delete',
        'last_login_at',
        'last_login_ip',
    ];

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
     *`
     * @var array
     */
    protected $casts = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['active_text'];

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeNotDelete(Builder $query): Builder
    {
        return $query->where('is_delete', 0);
    }


    /**
     * @param Builder $query
     * @param mixed $name
     *
     * @return Builder
     */
    public function scopeByName(Builder $query, $name): Builder
    {
        if (!empty($name)) {
            return $query->where('name', 'LIKE', "%$name%");
        }

        return $query;
    }


    /**
     * @param Builder $query
     * @param mixed $email
     *
     * @return Builder
     */
    public function scopeByEmail(Builder $query, $email): Builder
    {
        if (!empty($email)) {
            return $query->where('email', 'LIKE', "%$email%");
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @param mixed $role
     *
     * @return Builder
     */
    public function scopeByRole(Builder $query, $role): Builder
    {
        if (!empty($role)) {
            return $query->where('group_role', '=', $role);
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @param mixed $status
     *
     * @return Builder
     */
    public function scopeActive(Builder $query, $status): Builder
    {
        if (is_numeric($status)) {
            $query->where('is_active', '=', $status);
        }

        return $query;
    }

    public function getActiveTextAttribute()
    {
        return [
            'Tạm khóa',
            'Đang hoạt động',
        ][$this->is_active];
    }
}
