<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = array(
	"PARAMETERS" => array(
		"NEWS_IBLOCK_ID" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_NEWS_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"AUTHOR_PARAM_CODE" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_AUTHOR_PARAM_CODE"),
			"TYPE" => "STRING",
		),
		"USERFIELD_CODE" => array(
			"NAME" => GetMessage("SIMPLECOMP_EXAM2_USERFIELD_CODE"),
			"TYPE" => "STRING",
		),
		"CACHE_TIME"  =>  array("DEFAULT"=>36000000)
	),
);