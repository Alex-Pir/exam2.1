<?php

namespace Citrus\Events;

use Bitrix\Main\Localization\Loc;
use CEventLog;

Loc::loadMessages(__FILE__);

class Helper {
    public static function feedbackMessageHandler(&$arFields, $messageID) {
        global $USER;

        $name = "";

        if (array_key_exists("AUTHOR", $arFields) && !empty($arFields["AUTHOR"])) {
            $name = $arFields["AUTHOR"];
        }

        if (!$USER->isAuthorized()) {
            $arFields["AUTHOR"] = Loc::getMessage("EVENTS_HELPER_FEEDBACK_USER_NOT_FOUND_INFO", ["#AUTHOR_NAME#" => $name]);
        } else {

            $arFields["AUTHOR"] = Loc::getMessage("EVENTS_HELPER_FEEDBACK_USER_INFO", [
                "#ID#" => $USER->GetID(),
                "#LOGIN#" => $USER->GetLogin(),
                "#NAME#" => $USER->GetFullName(),
                "#AUTHOR_NAME#" => $name
            ]);
        }

        static::addMessageToSystemLog(Loc::getMessage("EVENTS_HELPER_FEEDBACK_MESSAGE_TO_LOG", ["#AUTHOR_NAME#" => $arFields["AUTHOR"]]), $messageID);
    }

    protected static function addMessageToSystemLog($message, $messageID) {

        if (!$message || !$messageID) {
            return;
        }

        CEventLog::Add([
            "SEVERITY" => "INFO",
            "AUDIT_TYPE_ID" => "EVENT_FEEDBACK",
            "MODULE_ID" => "main",
            "ITEM_ID" => $messageID,
            "DESCRIPTION" => $message,
        ]);
    }
}