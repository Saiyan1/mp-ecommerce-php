<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$url = $_SERVER['REQUEST_URI'];

if(strpos($url, "localhost") !== false){
    $host = "http://localhost/mp-ecommerce-php/";
} else{
    $host = "https://saiyan1-mp-commerce-php.herokuapp.com/";
}

// SDK de Mercado Pago
require __DIR__ .  '/vendor/autoload.php';
// Agrega credenciales
MercadoPago\SDK::setAccessToken('APP_USR-6317427424180639-042414-47e969706991d3a442922b0702a0da44-469485398');
MercadoPago\SDK::setIntegratorId("dev_24c65fb163bf11ea96500242ac130004");


// Crea un objeto de preferencia
$preference = new MercadoPago\Preference();

// Crea un ítem en la preferencia
$item = new MercadoPago\Item();
$item->id = 123;
$item->title = $_POST['title'];
$item->description = "Dispositivo móvil de Tienda e-commerce";
$item->picture_url = $host . $_POST['img'];
$item->quantity = 1;
$item->unit_price = $_POST['price'];
$preference->items = array($item);

//Pagador
$payer = new MercadoPago\Payer();
$payer->name = "Lalo";
$payer->surname = "Landa";
$payer->email = "test_user_63274575@testuser.com";
$payer->phone = array(
    "area_code" => "11",
    "number" => "22223333"
);

$payer->address = array(
    "street_name" => "Falsa",
    "street_number" => 123,
    "zip_code" => "1111"
);

$preference->payer = $payer;

//Excluir Metodos de pago
$payment_method = new MercadoPago\PaymentMethod();

$preference->payment_methods = array(
    "excluded_payment_methods" => array(
        array("id" => "amex")
    ),
    "excluded_payment_types" => array(
        array("id" => "atm")
    ),
    "installments" => 6
);

$preference->back_urls = array(
    "success" => $host . "cho-success.php",
    "pending" => $host . "cho-pending.php",
    "failure" => $host . "cho-failure.php"
);

$preference->auto_return = "approved";
$preference->external_reference = "insaurralde.ap@gmail.com";
$preference->notification_url = "https://gsocios.com/mp_certification/notifications.php";
$preference->save();

//var_dump( $preference->init_point );

$_SESSION['init_point'] = $preference->init_point;
$_SESSION['title'] = $_POST['title'];
$_SESSION['img'] = $host . $_POST['img'];
$_SESSION['price'] = $_POST['price'];
//var_dump($_SESSION);

header("Location: detail.php");
exit;
?>