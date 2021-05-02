<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var $arResult */
/** @var $arParams */


if ($arParams["SET_SPECIALDATE"] === 'Y' && isset($arResult["ITEMS"]) && !empty($arResult["ITEMS"])) {
    $arFirstElement = current($arResult["ITEMS"]);

    if (is_array($arFirstElement) && array_key_exists("DATE_ACTIVE_FROM", $arFirstElement)) {
        $arResult["DATE_ACTIVE_FIRST_ELEMENT"] = $arFirstElement["DATE_ACTIVE_FROM"];
        $this->__component->setResultCacheKeys(["DATE_ACTIVE_FIRST_ELEMENT"]);
    }
}