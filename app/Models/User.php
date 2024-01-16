<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "user";

    //SOMETIMES IF YPU ENCOUNTER AN ERROR LIKE TABLE NAME DOES NOT MATCH
    //ADD THE PROTECTED TABLE AND GIVE EXACT THE NAME OF THE TABLE IN ORDER TO AVOID ANY ERROR THAT COULD HAPPEN
    //INCASE IT STILL RETURN THE ERROR AFTER ADDING THE PROTECTED......JUST DO php artisan migrate:rollback
    //AND CHANGE THE ERRO TABLE NAME IT WANTS TO THE ONE IN THE USER TABLE FILE IN THE MIGRATION FOLDER
    //  Schema::create('user', function (Blueprint $table)  AND THIS TOO  Schema::dropIfExists('user');
    //THEN RUN php artisan migrate again 


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
    ];
}
