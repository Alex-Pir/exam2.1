<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент");
?><?$APPLICATION->IncludeComponent(
	"simplecomp.exam",
	"",
	Array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"NEWS_IBLOCK_ID" => "1",
		"NEWS_ID_LINK" => "UF_NEWS_LINK",
		"PRODUCTS_IBLOCK_ID" => "2"
	)
);?><? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php");?>