<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$arTemplateParameters = [

    "SET_SPECIALDATE" => [
        "NAME" => Loc::getMessage("T_NEWS_SPECIALDATE"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "N"
    ],
];