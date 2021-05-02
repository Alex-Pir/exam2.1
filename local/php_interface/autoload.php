<?php
use Bitrix\Main\Loader;

Loader::registerAutoLoadClasses(null, [
    "Citrus\\Events\\Handler" => "/local/lib/Events/Handler.php",
    "Citrus\\Events\\Helper" => "/local/lib/Events/Helper.php"
]);