<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    public $timestamps = true;

    protected $casts = [
        'price' => 'float'
    ];

    protected $fillable = [
        'name',
        'description',
        'price',
        'created_at'
    ];
/* 
    public function public($prodect_id) 
    {
        dd($prodect_id);
        $prodectExists = Product::where('id', $prodect_id)->exists();
        abort_unless($prodectExists, 404, 'Product not found');
     }
      */

      



      
}
