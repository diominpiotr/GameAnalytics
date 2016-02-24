<?php

namespace GameAnalytics\Event;

/**
 * Every game is unique! Therefore it varies what information is needed to track for each game.
 * 
 * Some needed events might not be covered by our other event types and the design event is available for creating a custom metric using an event id hierarchy.
 */
class EventDesign extends GameAnalyticsEvent {

    public function __construct() {
        $this->name(GAME_ANALYTICS_EVENT_DESIGN);
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
     * Optional value. float.
     *
     * @param String $value
     */
    public function value($value) {
        $this->annotations['value'] = $value;
        return $this;
    }

}
