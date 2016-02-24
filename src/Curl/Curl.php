<?php

namespace Curl;

class Response {

    private $ch = false;
    private $response = false;

    public function __construct($ch) {
        $this->ch = $ch;
        if (($this->response = curl_exec($this->ch)) === false) {
            throw new \Exception('Curl error: ' . $this->getError());
        }
    }

    public function get() {
        return $this->response;
    }

    public function getError() {
        return curl_error($this->ch);
    }

    public function getErrno() {
        return curl_errno($this->ch);
    }

    public function getInfo($key = false) {
        $response_info = curl_getinfo($this->ch);
        if ($key) {
            return $response_info[$key];
        }
        return $response_info;
    }

}

class Curl {

    private $ch = false;
    private $headers = array();
    private $opt = array();

    public function setHeader($option, $value) {
        if (is_null($value)) {
            return $this;
        }
        $this->headers[] = "{$option}: {$value}";
        return $this;
    }

    public function setOpt($option, $value) {
        $this->opt[$option] = $value;
        return $this;
    }

    public function post($url, $body = '') {
        if (!$this->init($url)) {
            return false;
        }
        $this->setOpt(CURLOPT_POST, true);
        if (!empty($body)) {
            $this->setOpt(CURLOPT_POSTFIELDS, $body);
        }
        try {
            return $this->get();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function get() {
        $this->setHeaders();
        $this->setOpts();
        try {
            return new Response($this->ch);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function init($url) {
        if (($this->ch = curl_init($url)) === false) {
            return false;
        }
        $this->setOpt(CURLOPT_RETURNTRANSFER, true);
        return true;
    }

    private function setOpts() {
        if (empty($this->opt)) {
            return false;
        }
        foreach ($this->opt as $option => $value) {
            curl_setopt($this->ch, $option, $value);
        }
    }

    private function setHeaders() {
        if (empty($this->headers)) {
            return false;
        }
        $this->setOpt(CURLOPT_HTTPHEADER, $this->headers);
    }

}
