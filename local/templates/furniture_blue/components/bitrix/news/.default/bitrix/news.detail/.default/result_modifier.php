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

global $USER, $APPLICATION;
$arResult["SEND_PARAMS"] = [
    "USER" => $USER->IsAuthorized() ? implode(', ', [$USER->GetID(), $USER->GetLogin(), $USER->GetFullName()]) : GetMessage("TPL_USER_NOT_FOUND"),
    "DATE" => date("d.m.Y H:i:s"),
    "NEW_ID" => $arResult["ID"],
    "URL" => $APPLICATION->GetCurPage(),
    "TYPE" => $arParams["USE_AJAX_REVIEW"] === 'Y' ? "REPORT_AJAX" : "REPORT"
];

