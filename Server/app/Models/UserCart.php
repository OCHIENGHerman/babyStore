<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'name',
        'image_url',
        'price',
        'quantity'
    ];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }
    
    public function product ()
    {
        return $this->belongsTo(Product::class);
    }
}
