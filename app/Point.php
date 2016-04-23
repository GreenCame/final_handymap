<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $fillable = [
        'rateValue', 'description', 'longitude', 'latitude', 'isValidate', 'create_at', 'update_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function confirmations()
    {
        return $this->hasMany('App\Confirmation');
    }

    public function confirmationsValid()
    {
        return $this->hasMany('App\Confirmation')->where("isConfirm","=",1);
    }

    public function confirmationsNotValid()
    {
        return $this->hasMany('App\Confirmation')->where("isConfirm","=",0);
    }
}
