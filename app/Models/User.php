<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Typeindustrie;
use App\Notifications\ResetPasswordNotification;
use App\Models\Assignment;


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
        'role',

        //info client
        'society',
        'type_ind',
        'responsable',
        'N_responsable',
        'country',
        'city',
        'address',

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

    public function client()
{
    return $this->belongsToMany(Assignment::class, 'assignment_client', 'client_id', 'assignment_id');
}

    public function typeIndustrie()
     {
        return $this->belongsTo(Typeindustrie::class);
    }



    public function sendPasswordResetNotification($token)
{   $email=$this->email;
    $url = url('/reset-password') . '/' . $token . '/' . $email;


    $this->notify(new ResetPasswordNotification($url));
}


}
