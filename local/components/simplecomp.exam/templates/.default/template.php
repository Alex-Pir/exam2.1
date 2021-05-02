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

<?if (array_key_exists("MIN_PRICE", $arResult) && array_key_exists("MIN_PRICE", $arResult)):
    $this->SetViewTarget("product_price");?>
    <div style="color:red; margin: 34px 15px 35px 15px">
        <?=GetMessage("SIMPLECOMP_EXAM2_MIN_PRICE", array("#MIN_PRICE#" => $arResult["MIN_PRICE"]))?>
        <?=GetMessage("SIMPLECOMP_EXAM2_MAX_PRICE", array("#MAX_PRICE#" => $arResult["MAX_PRICE"]))?>
    </div>
<?  $this->EndViewTarget();
endif;?>
