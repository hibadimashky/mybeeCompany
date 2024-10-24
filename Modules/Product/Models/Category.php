<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Models\Subcategory;
// use Modules\Product\Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'product_categories';
        
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name_ar',
        'name_en',
        'parent_id',
        'active',
        'order'
    ];

    public function getFillable(){
        return $this->fillable;
    }

    public $type = 'category';
    //public $childType = 'category';
    public $childType = 'subcategory';
    //public $childKey = 'parent_id';
    public $childKey = 'category_id';

    // public function children()
    // {
    //     return $this->hasMany(Category::class, 'parent_id');
    // }

    public function children()
    {
        return $this->hasMany(Subcategory::class, 'category_id', 'id')->whereNull('parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'category_id', 'id')->whereNull('parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
