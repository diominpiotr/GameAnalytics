<?php

namespace GameAnalytics\Event;

/**
 * As session is the concept of a user spending a period of time focused on a game. 
 * 
 * The user event acts like a session start. It should always be the first event in the first batch sent to the collectors and added each time a session starts.
 */
class EventUser extends GameAnalyticsEvent {

    public function __construct() {
        $this->name(GAME_ANALYTICS_EVENT_USER);
    }

}
