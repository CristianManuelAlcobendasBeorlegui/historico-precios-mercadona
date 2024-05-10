<?php

namespace App\Http\Controllers;

// === LIBRERIAS === //
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller {
    
    // === METODOS === //

    /** 
     * Actualiza / Importa las categorias del Mercadona.
     * */
    public function actualizaCategorias(): void {
        // Consigue todas las categorias
        $response = file_get_contents('https://tienda.mercadona.es/api/categories');
        $arrayCategories = json_decode($response, true)["results"];

        // Para cada categoria actualiza / importa sus datos
        foreach ($arrayCategories as $category) {
            // Datos de la categoria principal
            Category::updateOrCreate([
                'name' => $category['name'],
                'mercadona_id' => $category['id'],
                'mercadona_main_category_id' => $category['id'],
            ]);

            foreach ($category["categories"] as $subcategory) {
                // Datos de las subcategorias
                Category::updateOrCreate([
                    'name' => $subcategory['name'],
                    'mercadona_id' => $subcategory['id'],
                    'mercadona_main_category_id' => $category['id'],
                ]);
            }
        }
    }
}
