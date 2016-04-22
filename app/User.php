<?php

namespace App;
use Illuminate\Support\Facades\Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'firstname', 'lastname', 'pseudo', 'description', 'isVoice', 'isColor',  'password', "id", "isBlocked", "created_at"
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'isAdmin'
    ];

    public function feedbacks()
    {
       return $this->hasMany('App\Feedback');
    }

    public function feedbacksRemove()
    {
        $this->hasMany('App\Feedback')->delete();
    }

    public function pointsRemove()
    {
        $this->hasMany('App\Point')->where("isValidate", "=", false)->delete();
        $this->hasMany('App\Point')->where("isValidate", "=", true)->update(['user_id' => Auth::user()->id ]);
    }
}
