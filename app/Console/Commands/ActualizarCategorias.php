<?php

namespace App\Console\Commands;

use App\Http\Controllers\CategoryController;
use Illuminate\Console\Command;

class ActualizarCategorias extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:actualizar-categorias';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle() {
        $categoryController = new CategoryController();
        $categoryController->actualizaCategorias();
    }
}
