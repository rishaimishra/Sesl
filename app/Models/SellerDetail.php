<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Trails\HasUuid;
use Illuminate\Notifications\Notifiable;


class SellerDetail extends Model
{
    use Notifiable;

    protected $fillable = ['user_id','store_icon','store_name','store_location','store_document_1','store_document_2','store_document_3','store_document_4','store_category','store_category_name','is_verified','created_at','updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    
}