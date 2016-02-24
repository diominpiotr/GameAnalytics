<?php

namespace GameAnalytics\Event;

/**
 * Progression events are used to track attempts at completing levels in order to progress in a game. There are 3 types of progression events.
 * 
 * Start
 * Fail
 * Complete
 */
class EventProgression extends GameAnalyticsEvent {

    public function __construct() {
        $this->name(GAME_ANALYTICS_EVENT_PROGRESSION);
    }

    /**
     * Required - Yes
     * A 4 part event id string. [flowType]:[virtualCurrency]:[itemType]:[itemId]
     *
     * @param String $value
     */
    public function eventId($value) {
        $this->annotations['event_id'] = $value;
        return $this;
    }

    /**
     * Required - No
     * The number of attempts for this level. Add only when Status is “Complete” or “Fail”. Increment each time a progression attempt failed for this specific level.
     *
     * @param integer $value
     */
    public function attemptNum($value) {
        $this->annotations['attempt_num'] = $value;
        return $this;
    }

    /**
     * Required - No
     * An optional player score for attempt. Only sent when Status is “Fail” or “Complete”.
     *
     * @param integer $value
     */
    public function score($value) {
        $this->annotations['score'] = $value;
        return $this;
    }

}
