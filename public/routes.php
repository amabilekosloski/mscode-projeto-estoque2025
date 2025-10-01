    <?php

    use App\Controller\AppController;
    use App\Controller\Error\ErrorController;
    use App\Controller\Error\NotFoundController;
    use App\Controller\LoginController;
    use App\Controller\LogoutController;
    use App\Controller\ProdutosController;
    use App\Controller\CategoriasController;

    $router = [
        'routes' => [
        
            '/' => AppController::class,

            '/login' => LoginController::class,
            '/logout' => LogoutController::class,

            '/produtos' => ProdutosController::class,
            '/produtos/create' => ProdutosController::class,
            '/produtos/store' => ProdutosController::class,
            '/produtos/edit' => ProdutosController::class,
            '/produtos/update' => ProdutosController::class,
            '/produtos/delete' => ProdutosController::class,

            '/categorias' => CategoriasController::class,
            '/categorias/create' => CategoriasController::class,
            '/categorias/store' => CategoriasController::class,
            '/categorias/edit' => CategoriasController::class,
            '/categorias/update' => CategoriasController::class,
            '/categorias/delete' => CategoriasController::class,

            '/error' => ErrorController::class,
        ],
        'default' => NotFoundController::class
    ];