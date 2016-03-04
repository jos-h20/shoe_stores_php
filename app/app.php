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
    $app->post("/student_add_course", function() use ($app) {
        $course = Course::find($_POST['course_id']);
        $student = Student::find($_POST['student_id']);
        $student->addCourse($course);
        return $app['twig']->render('student.html.twig', array('student' => $student, 'courses' => $student->getCourses(), 'all_courses' => Course::getAll()));
    });
    $app->patch("/student/{id}/update", function($id) use ($app) {
        $student = Student::find($id);
        $new_name = $_POST['new_name'];
        $new_enrollment = $_POST['new_enrollment'];
        $student->update($new_name, $new_enrollment);
        return $app['twig']->render('student.html.twig', array('student' => $student, 'courses' => $student->getCourses(), 'all_courses' => Course::getAll()));
    });
    $app->delete("/student/{id}/delete", function($id) use ($app) {
        $student = Student::find($id);
        $student->delete();
        return $app['twig']->render("students.html.twig", array('students' => Student::getAll()));
    });
// BRANDS PAGE
    $app->post("/add_course", function() use ($app) {
        $name = $_POST['name'];
        $course_number = $_POST['course_number'];
        $id = null;
        $new_course = new Course($name, $course_number, $id);
        $new_course->save();
        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });
    $app->post("/delete_all_courses", function() use ($app) {
        Course::deleteAll();
        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });
    $app->get("/course/{id}", function($id) use($app) {
        $course = Course::find($id);
        return $app['twig']->render('course.html.twig', array('course' => $course, 'students' => $course->getStudents(), 'all_students' => Student::getAll()));
    });
    $app->post("/course_add_student", function() use ($app) {
        $student = Student::find($_POST['student_id']);
        $course = Course::find($_POST['course_id']);
        $course->addStudent($student);
        return $app['twig']->render('course.html.twig', array('course' => $course, 'students' => $course->getStudents(), 'all_students' => Student::getAll()));
    });
    $app->patch("/course/{id}/update", function($id) use ($app) {
        $course = Course::find($id);
        $new_name = $_POST['new_name'];
        $new_course_number = $_POST['new_course_number'];
        $course->update($new_name, $new_course_number);
        return $app['twig']->render('course.html.twig', array('course' => $course, 'students' => $course->getStudents(), 'all_students' => Student::getAll()));
    });
    $app->delete("/course/{id}/delete", function($id) use ($app) {
        $course = Course::find($id);
        $course->delete();
        return $app['twig']->render("courses.html.twig", array('courses' => Course::getAll()));
    });

    return $app;

    ?>
