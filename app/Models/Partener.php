<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
class Partener extends Authenticatable implements JWTSubject
{

    use SoftDeletes;
    protected $fillable = [
        'name_of_partener',
        'description',
        'img_path',
        'link_company_profile',
        'link_facebook',
        'link_whatsapp',
        'phone_number',
        'link_instigram',
    ];
    use HasFactory;
     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
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
