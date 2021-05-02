<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<p><b><?= GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE") ?></b></p>
<?
if (!array_key_exists("ITEMS", $arResult) || empty($arResult["ITEMS"])) {
    return;
}
?>

<div>
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
        <?= $arItem["NAME"] ?>
        <ul>
            <? foreach ($arItem["ELEMENTS"] as $arElement):
                if ($arElement["ELEMENT_VIEW"]):?>
                    <li>
                        <?= $arElement["ELEMENT_VIEW"] ?>
                    </li>
                <?
                endif;
            endforeach; ?>
        </ul>
    <? endforeach; ?>
</div>
