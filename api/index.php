<?php
/**
 * requires 
 */
require 'vendor/autoload.php';
require 'db/config.php';

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
    '/products/post',
    function () use($app, $db) {
        $app->response()->header("Content-Type", "application/json");
        $post = $app->request()->post();
        $body = $app->request->getBody();
        $result = $db->products->insert(json_decode($body, true));
        echo json_encode($body);
    }
);

// PUT route
$app->put(
    '/products/:id',
    function ($id) use($app, $db) {
      $app->response()->header("Content-Type", "application/json");
      $product = $db->products()->where("id", $id);
      if ($product[$id]) {
        $post = $app->request()->put();
        $body = $app->request->getBody();
        $result = $product->update(json_decode($body, true));
        echo json_encode(array(
          "status" => (bool)$result,
          "message" => "Product updated successfully."), 
            JSON_FORCE_OBJECT);
      } else {
        echo json_encode(array(
          "status" => false,
          "message" => "Product ID $id does not exist."),               
              JSON_FORCE_OBJECT);
      }
    }
);

// PATCH route
$app->patch('/patch', function () {
    echo 'This is a PATCH route';
});

// DELETE route
$app->delete(
    '/products/:id',
    function ($id) use ($app, $db) {
        $app->response()->header("Content-Type", "application/json");
        $product = $db->products()->where("id", $id);
        if ($product[$id]) {
          $result = $product->delete();
          echo json_encode(array(
            "status" => true,
            "message" => "Product deleted successfully."), 
              JSON_FORCE_OBJECT);
        } else {
          echo json_encode(array(
            "status" => false,
            "message" => "Delete failed. Product ID $id does not exist."),
              JSON_FORCE_OBJECT);
        }
    }
);

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
