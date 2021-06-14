<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arTemplateParameters = array(
	"CANONICAL_IBLOCK_ID" => Array(
		"NAME" => GetMessage("TPL_CANONICAL_IBLOCK_ID"),
		"TYPE" => "STRING"
	),
    "USE_AJAX_REVIEW" => Array(
        "NAME" => GetMessage("TPL_USE_AJAX_REVIEW"),
        "TYPE" => "CHECKBOX",
        "DEFAULT" => "",
    ),
);
