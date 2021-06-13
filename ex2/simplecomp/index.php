<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Простой компонент");
?><?$APPLICATION->IncludeComponent(
	"citrus:simplecomp.exam", 
	".default", 
	array(
		"AUTHOR_PARAM_CODE" => "AUTHOR",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"NEWS_IBLOCK_ID" => "1",
		"USERFIELD_CODE" => "UF_AUTHOR_TYPE",
		"COMPONENT_TEMPLATE" => ".default",
		"PRODUCT_IBLOCK_ID" => "2"
	),
	false
);?>Text here....<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>