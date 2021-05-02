<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var $APPLICATION */
/** @var $arResult */

if (array_key_exists("DATE_ACTIVE_FIRST_ELEMENT", $arResult)) {
    $APPLICATION->setDirProperty("specialdate", $arResult["DATE_ACTIVE_FIRST_ELEMENT"]);
}