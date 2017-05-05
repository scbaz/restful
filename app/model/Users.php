<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 2017/5/4
 * Time: 下午9:58
 */

namespace App\model;


use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Providers\JWT\JWTInterface;

class Users extends Model implements AuthenticatableContract
{
    use SoftDeletes, Authenticatable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    public static  $rules = [
        'password' => array('required', 'confirmed'),
        'password_confirmation' => array('required'),
        'email' => array('email', 'unique:users,email'),
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['password', 'email'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password'];
    public $timestamps = true;
    // jwt 需要实现的方法
    public function getJWTIdentifier()
    {
        return $this->id;
    }
    // jwt 需要实现的方法
    public function getJWTCustomClaims()
    {
        return [];
    }
}