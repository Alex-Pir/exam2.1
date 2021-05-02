<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

foreach ($arResult["ITEMS"] as $key => $arItem) {
    $arResult["ITEMS"][$key]["NAME"] = implode(" - ", array($arItem["NEWS_NAME"], $arItem["DATE"]));

    if (!empty($arItem["SECTION_NAME"])) {
        $arResult["ITEMS"][$key]["NAME"] .= ' (' . implode(", ", $arItem["SECTION_NAME"]) . ')';
    }

    foreach ($arItem["ELEMENTS"] as $elementKey => $arElement) {
        $arResult["ITEMS"][$key]["ELEMENTS"][$elementKey]["ELEMENT_VIEW"] = implode(" - ", array($arElement["NAME"], $arElement["PRICE"], $arElement["MATERIAL"], $arElement["ARTNUMBER"]));
    }
}


