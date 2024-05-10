<?php

namespace App\Http\Controllers;

// === LIBRERIAS === //
use App\Models\Category;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CategoryController extends Controller {
    
    // === METODOS === //

    /** 
     * Actualiza / Importa las categorias del Mercadona.
     * */
    public function actualizaCategorias(): void {
        $guzzleClient = new Client();

        // Consigue todas las categorias
        $response = $guzzleClient->request('GET', 'https://tienda.mercadona.es/api/categories/');
        $arrayCategories = json_decode($response->getBody(), true)['results'];

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

    /** 
     * Devuelve un array con todas las subcategorias guardadas en BD.
     * 
     * @return array
     * */
    public function obtenerSubcategorias() {
        return json_decode(Category::whereRaw('mercadona_id != mercadona_main_category_id')->get(), true);
    }
}
