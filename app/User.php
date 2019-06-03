<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Storage;
use App\Role;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getReceivers() {
        $role = new Role;
        $user = Auth::user();
        $user_role = Role::find($user->role_id);

        $receivers = null;
        switch($user_role->name) {
            case 'supplier':
                $receivers = $user->where('role_id', 2);
                break;
            case 'sales':
                $receivers = $user->where('role_id', 1);
                break;
        }
        
        return $receivers->get(['id', 'name', 'email']);
    }

    public function product($id) {
        return $this->hasOne('App\Product')->where('id', $id)->first();
    }

    public function products($storage_id) {
        return $this->hasMany('App\Product')->where('storage_id', $storage_id)->get();
    }

    public function storage($id) {
        return $this->hasOne('App\Storage')->where('id', $id);
    }
    public function storages() {
        return $this->hasMany('App\Storage');
    }
}
