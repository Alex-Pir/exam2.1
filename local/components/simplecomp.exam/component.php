<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if (!is_numeric($arParams["PRODUCTS_IBLOCK_ID"])
    || intval($arParams["PRODUCTS_IBLOCK_ID"]) <= 0
    || !is_numeric($arParams["NEWS_IBLOCK_ID"])
    || intval($arParams["NEWS_IBLOCK_ID"]) <= 0
) {
    ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_ID_IS_NOT_NUMERIC"));
    return;
}

if (empty($arParams["NEWS_ID_LINK"])) {
    ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_ID_IS_NOT_NUMERIC"));
    return;
}

if(!isset($arParams["CACHE_TIME"])) {
    $arParams["CACHE_TIME"] = 3600;
}


if ($this->startResultCache()) {

    $ufLinkProp = $arParams["NEWS_ID_LINK"];

    $arSectionFilter = array(
        "IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
        "ACTIVE" => "Y",
        "CHECK_PERMISSIONS" => "Y"
    );

    $arSectionSelect = array(
        "ID",
        "NAME",
        $ufLinkProp
    );

    $dbSection = CIBlockSection::GetList(array(), $arSectionFilter, false, $arSectionSelect);

    $arSectionsID = array();
    $arNewsID = array();

    while ($arResSection = $dbSection->GetNextElement()) {
        $sectionFields = $arResSection->GetFields();

        if (!array_key_exists($ufLinkProp, $sectionFields) || empty($sectionFields[$ufLinkProp])) {
            continue;
        }

        $arSectionsID[] = $sectionFields["ID"];

        foreach ($sectionFields[$ufLinkProp] as $field) {
            $arNewsID[] = $field;
            $arResult["ITEMS"][$field]["SECTION_NAME"][] = $sectionFields["NAME"];
            $arResult["ITEMS"][$field]["SECTION_ID"][] = $sectionFields["ID"];
        }
    }

    $arSectionsID = array_unique($arSectionsID);
    $arNewsID = array_unique($arNewsID);

    $arNewsFilter = array(
        "IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"],
        "ID" => $arNewsID,
        "ACTIVE" => "Y",
        "CHECK_PERMISSIONS" => "Y"
    );

    $arNewsSelect = array(
        "ID",
        "NAME",
        "DATE_ACTIVE_FROM"
    );

    $dbNews = CIBlockElement::GetList(array(), $arNewsFilter, false, false, $arNewsSelect);

    while ($arResNews = $dbNews->GetNextElement()) {
        $newsFields = $arResNews->GetFields();

        if (!array_key_exists($newsFields["ID"], $arResult["ITEMS"])) {
            continue;
        }

        $arResult["ITEMS"][$newsFields["ID"]]["NEWS_NAME"] = $newsFields["NAME"];
        $arResult["ITEMS"][$newsFields["ID"]]["DATE"] = $newsFields["DATE_ACTIVE_FROM"];
    }


    $arElementsFilter = array(
        "IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
        "IBLOCK_SECTION_ID" => $arSectionsID,
        "CHECK_PERMISSIONS" => "Y"
    );

    $arElementsSelect = array(
        "ID",
        "NAME",
        "IBLOCK_SECTION_ID",
        "PROPERTY_MATERIAL",
        "PROPERTY_ARTNUMBER",
        "PROPERTY_PRICE"
    );

    $dbElements = CIBlockElement::GetList(array(), $arElementsFilter, false, false, $arElementsSelect);

    $arElements = array();

    $elementIndex = 0;

    while ($arResElement = $dbElements->GetNextElement()) {
        $elementFields = $arResElement->GetFields();
        $arElements[$elementFields["IBLOCK_SECTION_ID"]][$elementIndex]["NAME"] = $elementFields["NAME"];
        $arElements[$elementFields["IBLOCK_SECTION_ID"]][$elementIndex]["MATERIAL"] = $elementFields["PROPERTY_MATERIAL_VALUE"];
        $arElements[$elementFields["IBLOCK_SECTION_ID"]][$elementIndex]["ARTNUMBER"] = $elementFields["PROPERTY_ARTNUMBER_VALUE"];
        $arElements[$elementFields["IBLOCK_SECTION_ID"]][$elementIndex]["PRICE"] = $elementFields["PROPERTY_PRICE_VALUE"];

        if (!isset($arResult["MAX_PRICE"]) || $elementFields["PROPERTY_PRICE_VALUE"] > $arResult["MAX_PRICE"]) {
           $arResult["MAX_PRICE"] = $elementFields["PROPERTY_PRICE_VALUE"];
        }
        
        if (!isset($arResult["MIN_PRICE"]) || $elementFields["PROPERTY_PRICE_VALUE"] < $arResult["MIN_PRICE"]) {
            $arResult["MIN_PRICE"] = $elementFields["PROPERTY_PRICE_VALUE"];
        }

        $elementIndex++;
    }

    $arResult["ELEMENTS_COUNT"] = $elementIndex;

    foreach ($arResult["ITEMS"] as $key => $arItems) {
        foreach ($arItems["SECTION_ID"] as $sectionID) {

            if (!array_key_exists("ELEMENTS", $arResult["ITEMS"][$key])) {
                $arResult["ITEMS"][$key]["ELEMENTS"] = $arElements[$sectionID];
            } else {
                $arResult["ITEMS"][$key]["ELEMENTS"] = array_merge($arResult["ITEMS"][$key]["ELEMENTS"], $arElements[$sectionID]);
            }
        }
    }

    $this->setResultCacheKeys(array(
        "ITEMS",
        "MAX_PRICE",
        "MIN_PRICE"
    ));

    $this->includeComponentTemplate();
}
$APPLICATION->setTitle(GetMessage("SIMPLECOMP_EXAM2_CATALOG_ELEMENTS_COUNT", array("#COUNT#" =>  $arResult["ELEMENTS_COUNT"])));