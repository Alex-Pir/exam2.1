<?php

namespace Citrus\Events;

class Handler {

    const EVENT_ID_FEEDBACK_FORM = "FEEDBACK_FORM";

    public static function onBeforeEventAdd($event, $lid, &$arFields, $messageID) {
        switch ($event) {
            case self::EVENT_ID_FEEDBACK_FORM:
                Helper::feedbackMessageHandler($arFields, $messageID);
                break;
            default:
                //nothing
                break;
        }
    }
}