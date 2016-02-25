# GameAnalytics

GameAnalytics API PHP

## Requirement

This library package requires PHP 5.3 or later.

Requiered the class UUID, the following class generates VALID RFC 4122 COMPLIANT
https://gist.github.com/dahnielson/508447

## Usage
```php
    include '../src/GameAnalytics/game_analytics_autoloader.php';

    use GameAnalytics\GameAnalytics;
    use GameAnalytics\Event\EventUser;

    $game_analytics = GameAnalytics::getInstance(<geme_key>, <secret_key>);
```
Example authentication.
```php
    $game_analytics
                ->set("foo", "var")
                ->authentication();
```
Use the set() function to configure the required annotations, you can use the array set annotations.
```php
    $game_analytics
            ->set(array(
                "foo" => "var",
                "foo2" => "var2"
            ))
            ->authentication();
```
Next, you can create "event" and use send() to send the event.
```php
    $event_user = new EventUser();
    $event_user
        ->device(<value>);

    $game_analytics
        ->set($event_user)
        ->send();
```

Available events

```php
    use GameAnalytics\Event\EventUser;
    use GameAnalytics\Event\EventSessionEnd;
    use GameAnalytics\Event\EventBusiness;
    use GameAnalytics\Event\EventProgression;
    use GameAnalytics\Event\EventResource;
    use GameAnalytics\Event\EventDesign;
    use GameAnalytics\Event\EventError;
```

### Complete example
Send event user.
```php
    use GameAnalytics\GameAnalytics;
    use GameAnalytics\Event\EventUser;

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

    $event_user = new EventUser();
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
```
