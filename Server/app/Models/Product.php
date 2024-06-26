<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'description',
        'image_url',
        'price',
        'quantity',
        'category_id',
    ];

    public function toSearchableArray()
    {
        return [ 
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'price' => $this->price,
            'quantity' => $this->quantity,
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function order_item()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
