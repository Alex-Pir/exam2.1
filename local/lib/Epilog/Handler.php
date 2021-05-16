<?php
namespace Citrus\Epilog;

use CEventLog;

class Handler {
    public static function onEpilogHandler() {

        if (defined('ERROR_404') && ERROR_404 === 'Y') {
            global $APPLICATION;

            $APPLICATION->RestartBuffer();

            include $_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/header.php";
            include $_SERVER["DOCUMENT_ROOT"] . "/404.php";
            include $_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/footer.php";

            CEventLog::Add([
                "SEVERITY" => "INFO",
                "AUDIT_TYPE_ID" => "ERROR_404",
                "MODULE_ID" => "main",
                "DESCRIPTION" => $APPLICATION->GetCurPage(false)
            ]);
        }
    }
}