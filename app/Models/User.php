<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Request;
use Illuminate\Notifications\Notifiable;
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
        'email',
        'password',
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
        'password' => 'hashed',
    ];

    static public function getAdmins(){
        $admins = self::select('users.*')
                        ->where('user_type',1)
                        ->where('status',1)
                        ->where('is_deleted',0);

        if(!empty(Request::get('name')))
        {
            $admins = $admins->where('name','like','%'.Request::get('name').'%');
        }
        if(!empty(Request::get('email')))
        {
            $admins = $admins->where('email','like','%'.Request::get('email').'%');
        }

        $admins = $admins->orderBy('id','DESC')
                        ->paginate(10);
        return  $admins;
    }
}
