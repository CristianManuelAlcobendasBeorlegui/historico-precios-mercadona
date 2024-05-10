<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    // === ATRIBUTOS === //
    protected $fillable = [ 'name', 'mercadona_id', 'categories_id', 'thumbnail', 'share_url', 'price', 'price_history' ];
}
