<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Department;
use App\Models\SipUser;
use App\Models\Credit;

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
        'email',
        'password',
        'status',
        'type',
        'profilePicture',
        'companyName'
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
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class, 'userId', 'id');
    }

    public function sipusers()
    {
        return $this->hasMany(SipUser::class, 'userId', 'id');
    }

    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function callCredit()
    {
        return $this->hasOne(Credit::class, 'userId', 'id')->where('type', '=', 'call');
    }
    public function packageCredit()
    {
        return $this->hasOne(Credit::class, 'userId', 'id')->where('type', '=', 'campaign');
    }
    
}
