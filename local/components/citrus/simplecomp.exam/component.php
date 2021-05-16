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

global $USER, $APPLICATION;

if (!$USER->IsAuthorized()) {
    $APPLICATION->AuthForm(GetMessage("SIMPLECOMP_EXAM2_USERS_IS_NOT_AUTHORIZED"));
}

if($this->StartResultCache(false, $USER->GetID()))
{
    $uniqNewsID = [];
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
			$arUserID[] = $author["ID"];
			$arResult["ITEMS"][$author["ID"]]["LOGIN"] = $author["LOGIN"];
		}

		if (!$arUserID) {
			throw new Exception(GetMessage("SIMPLECOMP_EXAM2_USERS_ID_NOT_FOUND"));
		}

		$arNewsFilter = [
			"IBLOCK_ID" => $arParams["NEWS_IBLOCK_ID"],
			"PROPERTY_{$arParams['AUTHOR_PARAM_CODE']}" => $arUserID,
            "CHECK_PERMISSIONS" => "Y"
		];


		$arNewsSelect = [
		    "ID",
			"NAME",
			"PROPERTY_{$arParams['AUTHOR_PARAM_CODE']}",
            "DATE_ACTIVE_FROM",
            "DATE_ACTIVE_TO"
		];

		$dbNews = CIBlockElement::GetList([], $arNewsFilter, false, false, $arNewsSelect);

		$newsID = [];

		while($arNews = $dbNews->Fetch()) {

		    $userId = $arNews["PROPERTY_{$arParams['AUTHOR_PARAM_CODE']}_VALUE"];

		    if (!in_array($arNews["ID"], $uniqNewsID)) {
                $uniqNewsID[] = $arNews["ID"];
            }

		    if ($userId == $USER->GetID()) {
                $newsID[] = $arNews["ID"];
            }

            $arResult["ITEMS"][$userId]["NEWS"][] = $arNews;
        }

        foreach ($arResult["ITEMS"] as $userKey => $arItems) {
            if ($userKey == $USER->GetID()) {
                continue;
            }

            foreach ($arItems["NEWS"] as $newKey => $arNews) {
                if (in_array($arNews["ID"], $newsID)) {
                    unset($arResult["ITEMS"][$userKey]["NEWS"][$newKey]);
                }
            }
        }

	} catch (Exception $ex) {
		AddMessage2Log($ex->getMessage());
		$this->AbortResultCache();
	} finally {
        $this->includeComponentTemplate();
        $APPLICATION->SetTitle(GetMessage("SIMPLECOMP_EXAM2_NEWS_COUNT", ["#COUNT#" => count($uniqNewsID)]));
    }
}