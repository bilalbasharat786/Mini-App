<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // NAYA: discount_price, color, aur size lazmi add karne hain yahan!
    protected $fillable = [
        'category_id', 'name', 'description', 'price', 'discount_price', 'stock', 
        'color', 'size', 'image_url', 'image_url_2', 'image_url_3', 'image_url_4'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }
}