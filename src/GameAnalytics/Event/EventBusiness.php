<?php

namespace GameAnalytics\Event;

/**
 * Business events are for real-money purchases.
 */
class EventBusiness extends GameAnalyticsEvent {

    public function __construct() {
        $this->name(GAME_ANALYTICS_EVENT_BUSINESS);
    }

    /**
     * Required - Yes
     * A 2 part event id. [itemType]:[itemId]
     *
     * @param String $value
     */
    public function eventId($value) {
        $this->annotations['event_id'] = $value;
        return $this;
    }

    /**
     * Required - Yes
     * The amount of the purchase in cents (integer)
     *
     * @param String $value
     */
    public function amount($value) {
        $this->annotations['amount'] = $value;
        return $this;
    }

    /**
     * Required - Yes
     * Currency need to be a 3 letter upper case string to pass validation.
     * In addition the currency need to be a valid currency for correct rate/conversion calculation at a later stage.
     * Look at the following link for a list valid currency values. http://openexchangerates.org/currencies.json.
     *
     * @param String $value
     */
    public function currency($value) {
        $this->annotations['currency'] = $value;
        return $this;
    }

    /**
     * Required - Yes
     * Similar to the session_num. Store this value locally and increment each time a business event is submitted during the lifetime (installation) of the game/app.
     *
     * @param String $value
     */
    public function transactionNum($value) {
        $this->annotations['transaction_num'] = $value;
        return $this;
    }

    /**
     * Required - No
     * A string representing the cart (the location) from which the purchase was made. Could be menu_shop or end_of_level_shop.
     * !Read about unique value limitations http://apidocs.gameanalytics.com/REST.html?http#limitations
     *
     * @param String $value
     */
    public function cartType($value) {
        $this->annotations['cart_type'] = $value;
        return $this;
    }

    /**
     * Required - No
     * A JSON object that can contain 3 fields: store, receipt and signature. Used for payment validation of receipts.
     * Currently purchase validation is only supported for iOS and Android stores.
     * 
     * For iOS the store is apple and the receipt is base64 encoded.
     * For Android the store is google_play and the receipt is base64 encoded + the IAP signature is also required.
     *
     * @param String $value
     */
    public function receiptInfo($value) {
        $this->annotations['receipt_info'] = $value;
        return $this;
    }

}
