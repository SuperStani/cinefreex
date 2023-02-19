<?php
require __DIR__ . '/vendor/autoload.php';

use Intervention\Image\ImageManagerStatic as Image;
define("PHOTO_PATH", "/var/www/cinefreex/img/");
define("LAYOUTS_PATH", "/scripts/cinefreex/photoshop/img");

if(isset($_GET["saveposter"], $_GET["source"], $_GET["pass"]) && $_GET["pass"] == '@Naruto96') {
    $main = Image::canvas(794, 1123, "#ff0000");
    $img = Image::make($_GET["source"])->heighten(1123);
    $main->insert($img, "center");
    $fileName = generateFileName();
    //echo $main->response();
    $main->save(PHOTO_PATH . $fileName . ".jpg");
    echo $fileName;
    die;
}

if(isset($_GET["saveEpisodePoster"], $_GET["source"], $_GET["pass"]) && $_GET["pass"] == '@Naruto96') {
    $img = Image::make($_GET["source"])->widen(1123);
    $img->save(PHOTO_PATH . "episodes/" . str_replace("/", "" , $_GET["fileName"]));
    die;
}

if(isset($_GET["saveSimulcastPoster"], $_GET["source"], $_GET["pass"]) && $_GET["pass"] == '@Naruto96') {
    $img = Image::make($_GET["source"])->widen(1123);
    $img->save(PHOTO_PATH . "simulcasts/" . str_replace("/", "" , $_GET["fileName"]) . ".jpg");
    die;
}

if(isset($_GET["poster"])) {
    $img = PHOTO_PATH . $_GET["poster"] . ".jpg";
    $main = Image::make($img);
    $logo = Image::make(LAYOUTS_PATH . "/cornice.png")->widen(794);
    //$name = $_GET["name"];
    $main->insert($logo, "center");
    echo $main->response();
    die;
}

if(isset($_GET["posterOrizzontale"])) {
    $img = $_GET["posterOrizzontale"];
    $main = Image::canvas(1280, 700, "#fffff");
    $img = Image::make($img)->heighten(700);
    $logo = Image::make(LAYOUTS_PATH . "/LayoutOrizzontale.png")->widen(1280);
    $main->insert($img, "center");
    $main->insert($logo, "center");
    echo $main->response();
    die;
}


function generateFileName() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 50; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}