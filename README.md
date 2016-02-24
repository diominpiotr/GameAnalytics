# GameAnalytics

GameAnalytics API PHP

## Requirement

This library package requires PHP 5.3 or later.

Requiered the class UUID, the following class generates VALID RFC 4122 COMPLIANT
https://gist.github.com/dahnielson/508447

## Usage
´´´php
    include '../../system/gameanalytics/config.php';
    include '../src/GameAnalytics/game_analytics_autoloader.php';
    include '../src/Curl/Curl.php';
    include '../src/UUID.php';

    use GameAnalytics\GameAnalytics;

    $game_analytics = GameAnalytics::getInstance(<geme_key>, <secret_key>);
´´´
Example authentication.

    $game_analytics
                ->set("foo", "var")
                ->authentication();

Use the set() function to configure the required annotations, you can use the array set annotations.

    $game_analytics
            ->set(array(
                "foo" => "var",
                "foo2" => "var2"
            ))
            ->authentication();

Next, you can create "event" and use send() to send the event.

    $event_user = new \GameAnalytics\Event\EventUser($authentication);
    $event_user
        ->device(<value>);

    $game_analytics
        ->set($event_user)
        ->send();

### Complete example

    use GameAnalytics\GameAnalytics;

    $game_analytics = GameAnalytics::getInstance(<geme_key>, <secret_key>);

    try {
        $game_analytics
                ->set("platform", "ios")
                ->set("os_version", "ios 8.2")
                ->set("sdk_version", "rest api v2")
                ->authentication();
    } catch (Exception $e) {
        die($e->__toString());
    }

    $event_user = new \GameAnalytics\Event\EventUser();
    $event_user
        ->device('unknown')
        ->v(2)
        ->userId('12345')
        ->sdkVersion('rest api v2')
        ->osVersion('android 4.4.4')
        ->manufacturer('samsung')
        ->platform('android');
    try {
        $game_analytics
                ->set($event_user)
                ->send();
    } catch (Exception $e) {
        die($e->__toString());
    }
