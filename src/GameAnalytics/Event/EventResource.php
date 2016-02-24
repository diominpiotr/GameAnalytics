<?php

namespace GameAnalytics\Event;

/**
 * Resource events are for tracking the flow of virtual currency registering the amounts users are spending (sink) and receiving (source) for a specified virtual currency.
 */
class EventResource extends GameAnalyticsEvent {

    public function __construct() {
        $this->name(GAME_ANALYTICS_EVENT_RESOURCE);
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
     * Required - Yes
     * The amount of the in game currency (float)
     *
     * @param String $value
     */
    public function amount($value) {
        $this->annotations['amount'] = $value;
        return $this;
    }

}
