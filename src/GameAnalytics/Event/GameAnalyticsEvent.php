<?php

namespace GameAnalytics\Event;

define('GAME_ANALYTICS_EVENT_USER', 'user');
define('GAME_ANALYTICS_EVENT_SESSION_END', 'session_end');
define('GAME_ANALYTICS_EVENT_BUSINESS', 'business');
define('GAME_ANALYTICS_EVENT_PROGRESSION', 'progression');
define('GAME_ANALYTICS_EVENT_RESOURCE', 'resource');
define('GAME_ANALYTICS_EVENT_DESIGN', 'design');
//define('GAME_ANALYTICS_EVENT_TROUBLESHOOTING', 'troubleshooting');
define('GAME_ANALYTICS_EVENT_ERROR', 'error');

/**
 * DOC: http://apidocs.gameanalytics.com/REST.html?python#default-annotations-shared
 */
abstract class GameAnalyticsEvent {

    protected $annotations;

    public function authentication($authentication) {
        if (!isset($authentication->server_ts)) {
            throw new GameAnalyticsException("Init request failed! Did not return proper server_ts..\n");
        }
        $this->clientTs($authentication->server_ts);
    }

    protected function name($value) {
        $this->annotations['category'] = $value;
        return $this;
    }

    /**
     * Required - Yes
     * examples: “iPhone6.1”, “GT-I9000”. If not found then “unknown”.
     * 
     * @param string $value
     */
    public function device($value) {
        $this->annotations['device'] = $value;
        return $this;
    }

    /**
     * Required - Yes
     * Reflects the version of events coming in to the collectors. Current version is 2.
     * 
     * @param integer $value
     */
    public function v($value) {
        $this->annotations['v'] = $value;
        return $this;
    }

    /**
     * Required - Yes
     * Use the unique device id if possible. For Android it’s the AID. Should always be the same across game launches.
     * 
     * @param string $value
     */
    public function userId($value) {
        $this->annotations['user_id'] = $value;
        return $this;
    }

    /**
     * Required - Yes
     * Timestamp when the event was created (put in queue/database) on the client. This timestamp should be a corrected one using an offset of time from server_time.
     * 
     * 1) The SDK will get the server TS on the init call (each session) and then calculate a difference (within some limit) from the local time and store this ‘offset’.
     * 2) When each event is created it should calculate/adjust the 'client_ts’ using the 'offset’.
     * 
     * @param integer $value
     */
    private function clientTs($value) {
        $this->annotations['client_ts'] = $value;
        return $this;
    }

    /**
     * Required - Yes
     * The SDK is submitting events to the servers. For custom solutions ALWAYS use “rest api v2”.
     * 
     * @param String $value
     */
    public function sdkVersion($value = 'rest api v2') {
        $this->annotations['sdk_version'] = $value;
        return $this;
    }

    /**
     * Required - Yes
     * Operating system version. Like “android 4.4.4”, “ios 8.1”.
     * 
     * @param String $value
     */
    public function osVersion($value = 'rest api v2') {
        $this->annotations['os_version'] = $value;
        return $this;
    }

    /**
     * Required - Yes
     * Manufacturer of the hardware the game is played on. Like “apple”, “samsung”, “lenovo”.
     * 
     * @param string $value
     */
    public function manufacturer($value) {
        $this->annotations['manufacturer'] = $value;
        return $this;
    }

    /**
     * Required - Yes
     * The platform the game is running. Platform is often a subset of os_version like “android”, “windows” etc.
     * 
     * @param string $value
     */
    public function platform($value) {
        $this->annotations['platform'] = $value;
        return $this;
    }

    /**
     * Required - Yes
     * Generate a random lower-case string matching the UUID:https://en.wikipedia.org/wiki/Universally_unique_identifier format.
     * Example:de305d54-75b4-431b-adb2-eb6b9e546014
     * 
     * @param string $value
     */
    public function sessionId($value) {
        $this->annotations['session_id'] = $value;
        return $this;
    }

    /**
     * Required - Yes
     * The SDK should count the number of sessions played since it was installed (storing locally and incrementing). The amount should include the session that is about to start.
     *
     * @param integer $value
     */
    public function sessionNum($value) {
        $this->annotations['session_num'] = $value;
        return $this;
    }

}
