<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
 use HasFactory;
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
    'image', 'title', 'slug', 'category_id', 'content', 'weight',
    'price', 'discount'
    ];

    /**
     * image
     *
     * @return Attribute
     */
    protected function image(): Attribute
    {
    return Attribute::make(
    get: fn ($value) => asset('/storage/products/' . $value),
    );
    }

    /**
     * category
     *
     * @return void
     */
    public function category()
    {
    return $this->belongsTo(Category::class);
    }
    
    /**
     * customer
     *
     * @return void
     */
    public function customer()
    {
    return $this->belongsTo(Customer::class);
    }

}

