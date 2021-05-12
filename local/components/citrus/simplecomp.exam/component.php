<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Main\UserTable,
	Bitrix\Iblock;

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

if (empty($arParams["NEWS_IBLOCK_ID"]) || $arParams["NEWS_IBLOCK_ID"] <= 0) {
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_ID_NOT_FOUND"));
	return;
}

if (empty($arParams["AUTHOR_PARAM_CODE"])) {
	ShowError(GetMessage("SIMPLECOMP_EXAM2_AUTHOR_CODE_NOT_FOUND"));
	return;
}

if (empty($arParams["USERFIELD_CODE"])) {
	ShowError(GetMessage("SIMPLECOMP_EXAM2_USERFIELD_NOT_FOUND"));
	return;
}

if (empty($arParams["CACHE_TIME"])) {
	$arParams["CACHE_TIME"] = 3600;
}

global $USER;

if($this->StartResultCache(false, $USER->GetID()))
{

	try {
		$authorGroup = UserTable::getList([
			"filter" => ["ID" => $USER->GetID()],
			"select" => [$arParams["USERFIELD_CODE"]]
		])->fetch();

		if (!$authorGroup || !array_key_exists($arParams["USERFIELD_CODE"], $authorGroup)) {
			throw new Exception(GetMessage("SIMPLECOMP_EXAM2_USER_NOT_FOUND"));
		}

		$authors = UserTable::getList([
			"filter" => [$arParams["USERFIELD_CODE"] => $authorGroup[$arParams["USERFIELD_CODE"]]],
			"select" => ["ID", "LOGIN"]
		])->fetchAll();

		$arUserID = [];

		foreach ($authors as $author) {
			$arUserID = $author["ID"];
			$arResult[$author["ID"]] = $author;
		}

		if (!$arUserID) {
			throw new Exception(GetMessage("SIMPLECOMP_EXAM2_USERS_ID_NOT_FOUND"));
		}

		$arNewsFilter = [
			"IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"],
			"PROPERTY_{$arParams['AUTHOR_PARAM_CODE']}" => $arUserID
		];


		$arNewsSelect = [
			"NAME",
			"PROPERTY_{$arParams['AUTHOR_PARAM_CODE']}"
		];

		$news = Iblock\ElementTable::getList([
			"filter" => $arNewsFilter,
			"select" => $arNewsSelect
		])->fetchAll();

		echo "<pre>";
		var_export($news);
		echo "</pre>";

		foreach ($news as $new) {

		}

	} catch (Exception $ex) {
		AddMessage2Log($ex->getMessage());
	}



	$arNewsFilter = [
		"IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"],
	];

	$arNewsSelect = [
		"ID",
		"NAME",
		"PROPERTY_{$arParams['AUTHOR_PARAM_CODE']}"
	];
	
	//iblock elements
	$arSelectElems = array (
		"ID",
		"IBLOCK_ID",
		"NAME",
	);
	$arFilterElems = array (
		"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
		"ACTIVE" => "Y"
	);
	$arSortElems = array (
			"NAME" => "ASC"
	);
	
	$arResult["ELEMENTS"] = array();
	$rsElements = CIBlockElement::GetList($arSortElems, $arFilterElems, false, false, $arSelectElems);
	while($arElement = $rsElements->GetNext())
	{
		$arResult["ELEMENTS"][] = $arElement;
	}
	
	//iblock sections
	$arSelectSect = array (
			"ID",
			"IBLOCK_ID",
			"NAME",
	);
	$arFilterSect = array (
			"IBLOCK_ID" => $arParams["PRODUCTS_IBLOCK_ID"],
			"ACTIVE" => "Y"
	);
	$arSortSect = array (
			"NAME" => "ASC"
	);
	
	$arResult["SECTIONS"] = array();
	$rsSections = CIBlockSection::GetList($arSortSect, $arFilterSect, false, $arSelectSect, false);
	while($arSection = $rsSections->GetNext())
	{
		$arResult["SECTIONS"][] = $arSection;
	}
		
	// user
	$arOrderUser = array("id");
	$sortOrder = "asc";
	$arFilterUser = array(
		"ACTIVE" => "Y"
	);
	
	$arResult["USERS"] = array();
	$rsUsers = CUser::GetList($arOrderUser, $sortOrder, $arFilterUser); // выбираем пользователей
	while($arUser = $rsUsers->GetNext())
	{
		$arResult["USERS"][] = $arUser;
	}	
	
	
}
$this->includeComponentTemplate();	
?>