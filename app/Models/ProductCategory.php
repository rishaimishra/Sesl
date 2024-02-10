<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = ['name', 'image', 'parent_id', 'is_active', 'sequence', 'sponsor_text','seller_detail_id'];

    const DOCUMENT_DIR  = 'basket/category';

    protected $appends = ['full_image'];

    function getFullImageAttribute()
    {

        if ($this->image) {
            return  asset('storage/' . $this->image);
        }
        return  asset('storage/images.png');
    }

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id')->withDefault();
    }

    public function children()
    {
        return $this->hasMany(static::class, 'parent_id')->orderBy('name', 'asc')->with('Children');
    }
    public function scopeRoot($query)
    {
        return $query->where('parent_id', null);
    }

    public function getName()
    {
        return ucfirst($this->name);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    public function scopeChild($query)
    {
        return $query->whereNotNull('parent_id');
    }
    public function categories()
    {
        return $this->belongsToMany(Product::class);
    }
}
