<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arParams */
/** @var array $arResult */

if (intval($arParams["CANONICAL_IBLOCK_ID"]) > 0) {
	$dbRes = CIBlockElement::GetList([], ["=PROPERTY_CANONICAL_NEWS" => $arResult["ID"]], false, false, ["NAME"]);

	if ($arRes = $dbRes->Fetch()) {
		$arResult["CANONICAL"] = $arRes["NAME"];
		$this->__component->setResultCacheKeys(["CANONICAL"]);
	}
}


