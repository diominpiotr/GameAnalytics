<?php

namespace GameAnalytics;

class GameAnalytics {

    private static $instance = false;
    private $secret_key = '';
    private $game_key = '';
    private $sandbox = false;
    private $protocol = 'http';
    private $gzip = true;
    private $debug = false;
    private $body = array();
    private $host = 'api.gameanalytics.com';
    private $curl = false;
    private $authentication = array();

    public function __construct($game_key, $secret_key) {
        $this->secret_key = $secret_key;
        $this->game_key = $game_key;
        $this->curl = new \Curl\Curl();
    }

    public static function getInstance($game_key = false, $secret_key = false) {
        if (!self::$instance instanceof GameAnalytics) {
            self:: $instance = new GameAnalytics($game_key, $secret_key);
        }
        return self::$instance;
    }

    public function authentication() {
        $host = $this->sandbox ? "sandbox-{$this->host}" : $this->host;
        $path = "v2/{$this->game_key}/init";
        try {
            $response = $this->curl
                    ->setOpt(CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1)
                    ->setHeader('Authorization', $this->getAuthorizationHash())
                    ->setHeader('Content-Type', 'application/json')
                    ->setHeader('Content-Encoding', $this->gzip ? true : null)
                    ->post("{$this->protocol}://{$host}/{$path}", $this->getBody());
            $this->checkResponseContent($response);
        } catch (GameAnalyticsException $e) {
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
        $response_content = json_decode($response->get());
        if (!isset($response_content->server_ts)) {
            throw new GameAnalyticsException("Init request failed! Did not return proper server_ts..\n");
        }
        $this->resetBody();
        $this->authentication = $response_content;
        return $this;
    }

    public function set($category, $value = null) {
        if (is_object($category)) {
            $category->authentication($this->authentication);
            $this->body[] = current((array) $category);
            return $this;
        }
        if (is_array($category)) {
            foreach ($category as $key => $value) {
                $this->body[$key] = $value;
            }
            return $this;
        }
        $this->body[$category] = array($category = $value);
        return $this;
    }

    public function send() {
        $host = $this->sandbox ? "sandbox-{$this->host}" : $this->host;
        $path = "v2/{$this->game_key}/events";
        try {
            $response = $this->curl
                    ->setOpt(CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1)
                    ->setHeader('Authorization', $this->getAuthorizationHash())
                    ->setHeader('Content-Type', 'application/json')
                    ->setHeader('Content-Encoding', $this->gzip ? true : null)
                    ->post("{$this->protocol}://{$host}/{$path}", $this->getBody());
            $this->checkResponseContent($response);
        } catch (GameAnalyticsException $e) {
            throw $e;
        } catch (Exception $e) {
            throw $e;
        }
        return true;
    }

    public function checkResponseContent($response) {
        if ($response->getInfo('http_code') == 500) {
            throw new GameAnalyticsException("Internal server error.\nMessage server:{$response->get()}\n");
        }
        if ($response->getInfo('http_code') == 401) {
            throw new GameAnalyticsException("Submit events failed due to UNAUTHORIZED.\nPlease verify your Authorization code is working correctly and that your are using valid game keys.\nMessage server:{$response->get()}\n");
        }
        if ($response->getInfo('http_code') == 400) {
            throw new GameAnalyticsException("Submit events failed due to BAD_REQUEST.\nReturned: {$response->getInfo('http_code')} response code.\nMessage server:{$response->get()}\n");
        }
        if ($response->getInfo('http_code') != 200) {
            throw new GameAnalyticsException("Init request did not return 200!\nReturned: {$response->getInfo('http_code')} response code.\nMessage server:{$response->get()}\n");
        }
    }

    public function debug($debug = true) {
        $this->debug = $debug;
        return $this;
    }

    public function sandbox($sandbox = true) {
        $this->sandbox = $sandbox;
        return $this;
    }

    public function gzip($gzip = true) {
        $this->gzip = $gzip;
        return $this;
    }

    public function https($https = true) {
        $this->protocol = $https ? 'https' : 'http';
        return $this;
    }

    private function getBody() {
        return json_encode($this->body);
    }

    public function resetBody() {
        $this->body = array();
        return $this;
    }

    public function getAuthorizationHash() {
        return base64_encode(hash_hmac('sha256', $this->getBody(), $this->secret_key, true));
    }

}
