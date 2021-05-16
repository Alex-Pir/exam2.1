<?php
use Bitrix\Main\Loader;

try {
    Loader::registerAutoLoadClasses(null, [
        "Citrus\\Events\\Handler" => "/local/lib/Events/Handler.php",
        "Citrus\\Events\\Helper" => "/local/lib/Events/Helper.php",
        "Citrus\\Epilog\\Handler" => "/local/lib/Epilog/Handler.php"
    ]);
} catch(Exception $ex) {
    AddMessage2Log($ex->getMessage());
}
