<?php
/**
 * requires 
 */
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
require 'db/config.php';
require 'db/NotORM.php';

/**
 * db stuff
 */
 
$pdo = new PDO(DSN, DB_USER, DB_PASS);
$db = new NotORM($pdo);

/**
 * Instantiate a Slim application
 */
$app = new \Slim\Slim();

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */

// Route for GET on all products
$app->get(
    '/products',
    function () use ($app, $db) {
        $products = array();
        foreach ($db->products() as $product){
            $products[] = [
              'id' => $product['id'],
              'sku' => $product['sku'],
              'description' => $product['description'],
              'price' => $product['price']
              ];
        }
        $app->response()->header("Content-Type", "application/json");
        echo json_encode($products, JSON_FORCE_OBJECT);
    }
);

// Route for GET on product by id
$app->get(
    '/products/:id',
    function ($id) use ($app, $db) {
        $app->response()->header("Content-Type", "application/json");
        //$product = $db->products[$id];
        $product = $db->products()->where("id", $id);
        if ($product[$id]) {
            echo json_encode($product[$id], JSON_FORCE_OBJECT);
        } else {
            echo json_encode(array(
                "status" => false,
                "message" => "Product ID $id does not exist."
                ), JSON_FORCE_OBJECT);
       }
    }
);


// POST route
$app->post(
    '/post',
    function () {
        echo 'This is a POST route';
    }
);

// PUT route
$app->put(
    '/put',
    function () {
        echo 'This is a PUT route';
    }
);

// PATCH route
$app->patch('/patch', function () {
    echo 'This is a PATCH route';
});

// DELETE route
$app->delete(
    '/delete',
    function () {
        echo 'This is a DELETE route';
    }
);

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
