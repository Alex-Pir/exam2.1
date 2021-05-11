<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arResult */

if (array_key_exists("CANONICAL", $arResult)) {
	global $APPLICATION;
	$APPLICATION->SetPageProperty("canonical", $arResult["CANONICAL"]);
}

