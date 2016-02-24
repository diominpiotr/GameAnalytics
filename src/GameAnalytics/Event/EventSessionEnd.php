<?php

namespace GameAnalytics\Event;

/**
 * Whenever a session is determined to be over the code should always attempt to add a session end event and submit all pending events immediately.
 * 
 * Only one session end event per session should be activated.
 */
class EventSessionEnd extends GameAnalyticsEvent {

    public function __construct() {
        $this->name(GAME_ANALYTICS_EVENT_SESSION_END);
    }

    /**
     * Required - Yes
     * Session length in seconds
     *
     * @param String $value
     */
    public function length($value) {
        $this->annotations['length'] = $value;
        return $this;
    }

}
