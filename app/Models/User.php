<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Intervention\Image\ImageManager;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'is_active', 'is_dstv_agent', 'is_edsa_password_set', 'edsa_password','is_edsa_agent','avatar', 'email', 'password', 'code', 'mobile_number', 'mobile_verified_at', 'username','current_otp','is_seller'
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
    protected $appends = ['phone_number'];

    public function getPhoneNumberAttribute()
    {
        return $this->mobile_number;
    }

    public function digitalAddresses()
    {
        return $this->hasMany(DigitalAddress::class);
    }

    public function routeNotificationForTwilio()
    {
        return $this->mobile_number;
    }

    public function hasVerifiedMobile()
    {
        return !is_null($this->mobile_verified_at);
    }

    public function userVerifications()
    {
        return $this->hasMany(UserVerification::class);
    }

    public function getUploadDir()
    {
        return "/avatars/{$this->id}";
    }

    public function getAvatar($width = 300, $height = 200, $resize = false)
    {
        /*$img = \Image::make(storage_path('app/' . $this->avatar));

        $newPath = '/media/' .  pathinfo($this->avatar, PATHINFO_FILENAME) . '-' . $width . '-' . $height . '.' . pathinfo($this->avatar, PATHINFO_EXTENSION);
        $cropPath = public_path($newPath);

        $img = $img->crop(intval($width), intval($height));

        $img->save($cropPath);*/
        $manager = new ImageManager(array('driver' => 'imagick'));
        $image = $manager->make(storage_path('app/' . $this->avatar))->resize(300, 200);
        return $image;
        //return  (!empty($this->avatar) ? \Image::url($this->avatar,$width,$height, $resize ? [] : ['crop']) : \Image::url(asset('images/default.jpg'), $width, $height, $resize ? [] : ['crop']));
    }

    /**
     * Get the phone record associated with the user.
     */
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function savedmeters()
    {
        return $this->hasMany(SavedMeter::class);
    }


    public function saveddstvrechargecards()
    {
        return $this->hasMany(SavedDstvRechargeCard::class);
    }
    
    
    public function interestedAutos()
    {
        return $this->belongsToMany(Auto::class, 'auto_interested_user')->withTimestamps();
    }

    public function interestedRealEstate()
    {
        return $this->belongsToMany(RealEstate::class, 'real_estate_interested_user')->withTimestamps();
    }

    public function storeDetails()
    {
        return $this->hasOne(SellerDetail::class);
    }
}
