<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?= GetMessage("EXAM_TEXT_PAGE_FOR_EXAM");

echo GetMessage("EXAM_TEXT_PARAM1", array("#PARAM1#" => $arResult["VARIABLES"]["PARAM1"]));
echo GetMessage("EXAM_TEXT_PARAM2", array("#PARAM2#" => $arResult["VARIABLES"]["PARAM2"]));
