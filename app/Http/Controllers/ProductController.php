<?php

namespace App\Http\Controllers;

// === LIBRERIAS === //

use App\Models\Product;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProductController extends Controller {
    // === METODOS === //

    /** 
     * Importa / Actualiza productos de diferentes categorias.
     * */
    public function actualizaProductos(): void {
        $categoryController = new CategoryController();
        $guzzleClient = new Client();
        
        // Consigue todas las subcategorias guardadas en BD
        $arrayDbSubcategories = $categoryController->obtenerSubcategorias();

        // Desordena el array de subcategorias y guarda el primer 1/10
        shuffle($arrayDbSubcategories);
        $arrayDbSubcategories = array_slice($arrayDbSubcategories, 0, intdiv(count($arrayDbSubcategories), 10));
        
        foreach ($arrayDbSubcategories as $dbSubcategory) {
            // Guarda en un array todas las categorias de la API
            $response = $guzzleClient->request('GET', 'https://tienda.mercadona.es/api/categories/' . $dbSubcategory['mercadona_id'] . '/');
            $arrayCategories = json_decode($response->getBody(), true)['categories'];
            
            foreach ($arrayCategories as $category) {
                // Guarda en un array los productos de la categoria actual
                $arrayProducts = $category['products'];

                foreach ($arrayProducts as $product) {
                    // Guarda las categorias a las que pertenece el producto
                    $arrayProductCategories = [];
                    if (isset($product['categories'])) {
                        foreach ($product['categories'] as $productCategory) {
                            array_push($arrayProductCategories, $productCategory['id']);
                        }
                    }

                    // Inserta / Actualiza los datos del producto actual
                    $dbProduct = json_decode(Product::updateOrCreate(
                        [
                            'mercadona_id' => $product['id'],
                        ],
                        [
                            'mercadona_id' => $product['id'],
                            'name' => $product['display_name'],
                            'categories_id' => json_encode($arrayProductCategories),
                            'thumbnail' => $product['thumbnail'] ?? null,
                            'share_url' => $product['share_url'] ?? null,
                            'price' => $product['price_instructions']['unit_price'],
                        ]), true);

                    // Comprueba si el producto actual lleva un historico de precios
                    $arrayPriceHistory = json_decode(json_decode(Product::where([ 'id'  => $dbProduct['id'] ])->first(), true)['price_history'], true);

                    if (count($arrayPriceHistory) > 0) {
                        // Comprueba si el precio actual es diferente al del historico
                        if ($arrayPriceHistory[0]['price'] != $dbProduct['price']) {
                            // Anyade la fecha actual y el precio
                            array_unshift($arrayPriceHistory, [ 'date' => date('d-m-y H:i'), 'price' => $dbProduct['price'] ]);
                        }
                    } else {
                        $arrayPriceHistory = [ ['date' => date('d-m-y H:i'), 'price' => $dbProduct['price']] ];
                    }

                    // Anyade el historico de precios al producto
                    Product::where([ 'id' => $dbProduct['id'] ])
                            ->update([
                                'price_history' => json_encode($arrayPriceHistory),
                            ]);
                }
            }
        }
    }
}
