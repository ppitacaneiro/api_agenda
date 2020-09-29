<?php
require_once 'Database.php';
require_once 'ContactsController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

$requestMethod = $_SERVER["REQUEST_METHOD"];

$id = null;
if (isset($_GET['id']))
{
    $id = $_GET['id'];
}

$database = new DataBase();
$db = $database->getConnection();

$controller = new ContactsController($db,$requestMethod,$id);
$controller->processRequest();

?>