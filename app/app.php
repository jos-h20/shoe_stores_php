<?php
    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Store.php';
    require_once __DIR__.'/../src/Brand.php';

    $server = 'mysql:host=localhost;dbname=shoes';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app = new Silex\Application();

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));
// INDEX PAGE
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });
    $app->get("/stores", function() use ($app) {
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });
    $app->get("/brands", function() use ($app) {
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });

    $app->post("/delete_all", function() use ($app) {
        Brand::deleteAll();
        Store::deleteAll();
        return $app['twig']->render('index.html.twig');
    });
// STORES PAGE
    $app->post("/add_store", function() use ($app) {
        $store_name = $_POST['store_name'];
        $id = null;
        $new_store = new Store($store_name, $id);
        $new_store->save();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });
    $app->post("/delete_all_stores", function() use ($app) {
        Store::deleteAll();
        return $app['twig']->render('stores.html.twig', array('stores' => Store::getAll()));
    });
    $app->get("/store/{id}", function($id) use($app) {
        $store = Store::find($id);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'all_brands' => Brand::getAll()));
    });
    //STORE PAGE
    $app->post("/store_add_brand", function() use ($app) {
        $brand = Brand::find($_POST['brand_id']);
        $store = Store::find($_POST['store_id']);
        $store->addBrand($brand);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'all_brands' => Brand::getAll()));
    });
    $app->patch("/store/{id}/update", function($id) use ($app) {
        $store = Store::find($id);
        $new_store_name = $_POST['new_store_name'];
        $store->update($new_store_name);
        return $app['twig']->render('store.html.twig', array('store' => $store, 'brands' => $store->getBrands(), 'all_brands' => Brand::getAll()));
    });
    $app->delete("/store/{id}/delete", function($id) use ($app) {
        $store = Store::find($id);
        $store->delete();
        return $app['twig']->render("stores.html.twig", array('stores' => Store::getAll()));
    });
// BRANDS PAGE
    $app->post("/add_brand", function() use ($app) {
        $brand_name = $_POST['brand_name'];
        $id = null;
        $new_brand = new Brand($brand_name, $id);
        $new_brand->save();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });
    $app->post("/delete_all_brands", function() use ($app) {
        Brand::deleteAll();
        return $app['twig']->render('brands.html.twig', array('brands' => Brand::getAll()));
    });
    $app->get("/brand/{id}", function($id) use($app) {
        $brand = Brand::find($id);
        return $app['twig']->render('brand.html.twig', array('brand' => $brand, 'stores' => $brand->getStores(), 'all_stores' => Store::getAll()));
    });
    //BRAND PAGE
    $app->post("/brand_add_store", function() use ($app) {
        $store = Store::find($_POST['store_id']);
        $brand = Brand::find($_POST['brand_id']);
        $brand->addStore($store);
        return $app['twig']->render('brand.html.twig', array('brand' => $brand, 'stores' => $brand->getStores(), 'all_stores' => Store::getAll()));
    });
    // $app->patch("/course/{id}/update", function($id) use ($app) {
    //     $course = Brand::find($id);
    //     $new_name = $_POST['new_name'];
    //     $new_course_number = $_POST['new_course_number'];
    //     $course->update($new_name, $new_course_number);
    //     return $app['twig']->render('course.html.twig', array('course' => $course, 'students' => $course->getStudents(), 'all_students' => Student::getAll()));
    // });
    // $app->delete("/course/{id}/delete", function($id) use ($app) {
    //     $course = Course::find($id);
    //     $course->delete();
    //     return $app['twig']->render("courses.html.twig", array('courses' => Course::getAll()));
    // });

    return $app;

    ?>
