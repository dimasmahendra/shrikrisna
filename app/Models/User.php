<?php

namespace App\Models;

use App\Models\UserFavorites;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $appends = ["gambar_url"];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getGambarUrlAttribute()
    {
        if (empty($this->photo)) {
            return url('cms/images/samples/no_user_60.png');
        } else {
            if ($this->photo == 'no-image.svg') {
                return url('cms/images/samples/no_user_60.png');
            } else {
                if(file_exists(storage_path('/app/public/') . $this->photo)){
                    return Storage::url($this->photo);
                } else {
                    return url('cms/images/samples/no_user_60.png');
                }
            }
        }
    }

    public function role()
    {
        return $this->hasOne(AuthRole::class, 'id', 'id_role');
    }
}
