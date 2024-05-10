<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    use HasFactory;

    // === ATRIBUTOS === //
    protected $fillable = [ "name", "mercadona_id", "mercadona_main_category_id" ];
}
