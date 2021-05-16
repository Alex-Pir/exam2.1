<?php

$eventManager = \Bitrix\Main\EventManager::getInstance();

$eventManager->addEventHandler("main", "OnBeforeEventAdd", ["Citrus\\Events\\Handler", "onBeforeEventAdd"]);
$eventManager->addEventHandler("main", "OnEpilog", ["Citrus\\Epilog\\Handler", "onEpilogHandler"]);