<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arResult */

if (array_key_exists("CANONICAL", $arResult)) {
	global $APPLICATION;
	$APPLICATION->SetPageProperty("canonical", $arResult["CANONICAL"]);
}

if ($_REQUEST['TYPE'] === 'REPORT' || $_REQUEST['TYPE'] === 'REPORT_AJAX') {
    $user = $_REQUEST['USER'];
    $date = $_REQUEST['DATE'];
    $new = $_REQUEST['NEW'];

    $element = new CIBlockElement();

    if ($id = $element->Add([
        "IBLOCK_ID" => 5,
        "NAME" => $user,
        "PROPERTY_VALUES" => [
            "USER" => $user,
            "NEW" => $new
        ]
    ])) {
        if ($_REQUEST['TYPE'] === 'REPORT_AJAX') {
            $APPLICATION->RestartBuffer();
            $result = ["MESSAGE" => GetMessage("TPL_REPORT_RESULT", ["#COUNT#" => $id])];
            echo Bitrix\Main\Web\Json::encode($result);
            die();
        } else {
            LocalRedirect($APPLICATION->GetCurPage() . "?ID=$id&TYPE_RESPONSE=RESPONSE");
        }

    } else {
        if ($_REQUEST['TYPE'] === 'REPORT_AJAX') {
            $APPLICATION->RestartBuffer();
            echo Bitrix\Main\Web\Json::encode(["MESSAGE" => GetMessage("TPL_REPORT_ERROR")]);
            die();
        } else {
            LocalRedirect($APPLICATION->GetCurPage() . "?TYPE_RESPONSE=RESPONSE&MESSAGE=" . GetMessage("TPL_REPORT_ERROR"));
        }
    }

}