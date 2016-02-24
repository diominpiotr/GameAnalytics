<?php

include '../../system/gameanalytics/config.php';
include '../src/GameAnalytics/game_analytics_autoloader.php';

use GameAnalytics\GameAnalytics;

try {
    GameAnalytics::getInstance(GAME_ANALYTICS_GAME_KEY, GAME_ANALYTICS_SECRET_KEY)
            ->set("platform", "ios")
            ->set("os_version", "ios 8.2")
            ->set("sdk_version", "rest api v2")
            ->authentication();
} catch (Exception $e) {
    die($e->__toString());
}

$EventGameAnalyticsUser = new \GameAnalytics\Event\EventUser();
$EventGameAnalyticsUser
        ->device('unknown')
        ->v(2)
        ->userId('12345')
        ->sdkVersion('rest api v2')
        ->osVersion('android 4.4.4')
        ->manufacturer('samsung')
        ->platform('android')
        ->sessionId(UUID::v4())
        ->sessionNum(123);
try {
    GameAnalytics::getInstance()
            ->set($EventGameAnalyticsUser)
            ->send();
} catch (Exception $e) {
    die($e->__toString());
}
echo "Send event:OK\n";
