<?php

$mapping = array(
    'GameAnalytics\GameAnalytics' => 'GameAnalytics.php',
    'GameAnalytics\Event\GameAnalyticsEvent' => 'Event/GameAnalyticsEvent.php',
    'GameAnalytics\Event\EventUser' => 'Event/EventUser.php',
    'GameAnalytics\Event\EventSessionEnd' => 'Event/EventSessionEnd.php',
    'GameAnalytics\Event\EventBusiness' => 'Event/EventBusiness.php',
    'GameAnalytics\Event\EventProgression' => 'Event/EventProgression.php',
    'GameAnalytics\Event\EventResource' => 'Event/EventResource.php',
    'GameAnalytics\Event\EventDesign' => 'Event/EventDesign.php',
    'GameAnalytics\Event\EventUser' => 'Event/EventUser.php',
    'GameAnalytics\Event\EventError' => 'Event/EventError.php',
    'GameAnalytics\GameAnalyticsException' => 'GameAnalyticsException.php'
);

spl_autoload_register(function ($class) use ($mapping) {
    if (isset($mapping[$class])) {
        require $mapping[$class];
    }
}, true);

include '../src/Curl/Curl.php';
include '../src/UUID.php';
