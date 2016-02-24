<?php

namespace GameAnalytics\Event;

/**
 * An Error event should be sent whenever something horrible has happened in your code - some Exception/state that is not intended.
 * 
 * the following error types are supported. 
 * 
 * debug
 * info
 * warning
 * error
 * critical
 * 
 * Do not send more than 10 error events pr. game launch!
 * 
 * The error events can put a high load on the device the game is running on if every Exception is submitted.
 * This is due to Exceptions having a lot of data and that they can be fired very frequently (1000/second is possible). 
 * 
 * The GameAnalytics servers will block games that send excessive amounts of Error events. 
 * 
 * Simple solution
 * Keep track of how many is sent and stop sending when the threshold is reached. 
 * 
 * More advanced
 * Keep track of each type of Exception sent in a list. If an error event match a type already sent then ignore.
 * If 10 types have been sent then stop sending. This will ensure that 10 similar Error events fired quickly will not result in other types not being discovered. 
 * 
 * The idea is that developers should discover an error in the GameAnalytics tool and then fix the cause by submitting a new version of the app. 
 * Even with the limit of 10 error events this should still be possible.
 */
class EventError extends GameAnalyticsEvent {

    public function __construct() {
        $this->name(GAME_ANALYTICS_EVENT_ERROR);
    }

    /**
     * Required - Yes
     * The type of error severity.
     *
     * @param String $value
     */
    public function severity($value) {
        $this->annotations['severity'] = $value;
        return $this;
    }

    /**
     * Required - No
     * Stack trace or other information detailing the error. Can be an empty string.
     *
     * @param String $value
     */
    public function message($value) {
        $this->annotations['message'] = $value;
        return $this;
    }

}
