<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/** @var array $arResult */

if (!array_key_exists("ITEMS", $arResult) || empty($arResult["ITEMS"])) {
    return;
}
?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
<?foreach ($arResult["ITEMS"] as $userID => $arItems):?>
<ul>
    <?if (isset($arItems["LOGIN"]) && !empty($arItems["LOGIN"])):?>
        <div>
            [<?=$userID?>] - <?=$arItems["LOGIN"]?>
        </div>
    <?endif;
    foreach ($arItems["NEWS"] as $arNews):
    ?>
        <?if (isset($arNews) && !empty($arNews)):?>
            <li>
                - <?= $arNews["NAME"]?>
            </li>
        <?endif;?>
    <?endforeach;?>
</ul>
<?endforeach;?>
