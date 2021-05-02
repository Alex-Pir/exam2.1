<?php

namespace Citrus\Events;

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class Helper {
    public static function feedbackMessageHandler(&$arFields) {
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
    }
}