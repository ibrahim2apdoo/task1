<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Translatable\HasTranslations;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject{

    use HasTranslations;

    public $translatable = ['name'];

    protected $table='admins';
    protected $fillable=['name','email','password'];

    public function getActive(){
        return $this->status == 1 ? trans('admin.active') :trans('admin.notActive') ;
    }
    public function Is_admin(){
        return $this->Is_admin == 1 ? trans('admin.admin') : trans('admin.noadmin') ;
    }
    public function categories(){
        return $this->hasMany('App\Models\Admin','added_by');
    }

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
}
