<?php

/**
 * Handles the API-Request.
 *
 *
 * 2012 by timpietrusky.com
 *
 * Licensed under VVL 1.33b7 - timpietrusky.com/license
 */

// Enable server-side Google Analytics
include('php-ga/autoload.php');
use UnitedPrototype\GoogleAnalytics;

class Request {
    protected $resource;
    protected $recource_parts;

    protected $A;
    protected $B;
    protected $C;

    protected $valid = true;



    function __construct() {
        // Get the resource without query
        $this->resource = $this->stripQueryString($_SERVER['REQUEST_URI']);

        // Get the resource parts
        $this->resource_parts = $this->splitResourceString($this->resource);

        // Set the different request-types
        $type_home = Config::getConfig()->type_home;
        $type_user = Config::getConfig()->type_user;
        $type_none = Config::getConfig()->type_none;

        // Handle resource parts: http://api.tld/A/B/C
        // A
        if (!is_null($this->getA())) {
            // A is 'home' if one of the following matches: picks|popular|recent
            if (in_array($this->getA(), explode("|", Config::getConfig()->request_a))) {
                $this->A = $type_home;
            // A is a username
            } else {
                $this->A = $type_user;
            }
        // Nothing specified -> invalid request
        } else {
            $this->A = $type_none;
        }

        // B
        if ($this->A != $type_none && !is_null($this->getB())) {
            // A is a username
            if ($this->getA() == $type_user) {
                // B is one of the following: owned|love|details
                if (in_array($this->getB(), explode("|", Config::getConfig()->request_b_user))) {
                    $this->B = $this->getB();
                } else {
                    $this->B = $type_none;

                    // A is a username but B is not specified -> invalid request
                    $this->valid = false;
                }
            // A is home
            } else {
                $this->B = $this->getB();
            }
        } else {
            // B is not specified
            $this->B = $type_none;

            // 'user'
            if ($this->getA() == $type_user) {
                // B is not set, so show the default "owned" #8
                $this->B = 'owned';
                $this->valid = true;
            }

            // 'home'
            if ($this->getA() == $type_home) {
                // Set a default value cause 'home' needs no specific B
                $this->B = 1;
            }
        }

        // C
        if ($this->A != $type_none && !is_null($this->getC())) {
            // C is an Integer
            if (strval(intval($this->getC())) === strval($this->getC())) {
                $this->C = $this->getC();

            // C is a CodePen  
            } else if (strlen($this->getC()) == 5) {
                $this->C = $this->getC();

            // C is invalid
            } else {
                $this->C = $type_none;
                $this->valid = false;
            }
        // C is not specified
        } else {
            $this->C = $type_none;

            // 'user'
            if ($this->getA() == $type_user) {

                if ($this->getB() == 'pen') {
                    // @TODO [TimPietrusky] - Add a custom error
                    $this->valid = false;
                } else {
                    // Set a default value
                    $this->C = 1;
                }
            }
        }

        // Track the request
        if ($this->A != $type_none && $this->valid) {
            $this->track();
        }
    }

    public function getA($raw = false) {
        if (isset($this->A) && !$raw) {
            return $this->A;
        } else {
            return $this->getResourcePart(1);
        }
    }

    public function getB($raw = false) {
        if (isset($this->B) && !$raw) {
            return $this->B;
        } else {
            return $this->getResourcePart(2);
        }
    }

    public function getC($raw = false) {
        if (isset($this->C) && !$raw) {
            return $this->C;
        } else {
            return $this->getResourcePart(3);
        }
    }

    /**
     * Returns <CODE>true</CODE> if the API-Request is valid,
     * <CODE>false</CODE> otherwise.
     *
     * @return boolean $valid
     */
    public function isValid() {
        return $this->valid;
    }

    /**
     * Returns the specified <CODE>resource_parts[$i]</CODE>.
     *
     * @param int $i
     *
     * @return mixed
     */
    public function getResourcePart($i) {
        if (isset($this->resource_parts[$i])) {
            return $this->resource_parts[$i];
        }

        return null;
    }

    /**
     * Removes the query from the resource.
     *
     * @param String $uri
     *
     * @return String
     */
    private function stripQueryString($uri) {
        $questionMarkPosition = strpos($uri, '?');
        if ($questionMarkPosition !== false) {
            return substr($uri, 0, $questionMarkPosition);
        }

        return $uri;
    }

    /**
     * Splits the resource into different parts.
     *
     * @param String $resourceString
     *
     * @return Array $parts
     */
    private function splitResourceString($resourceString) {
        $parts = array_filter(explode('/', $resourceString), array($this, 'resourceFilter'));

        return $parts;
    }

    /**
     * Filter for <CODE>splitResourceString</CODE>.
     *
     * @param String $input
     */
    private function resourceFilter($input) {
        return trim($input) != '';
    }

    /**
     * Track the request with Google Analytics.
     */
    private function track() {
        // Initilize GA Tracker
        $tracker = new GoogleAnalytics\Tracker('UA-5596313-3', 'codepen-awesomepie.timpietrusky.com');

        // Assemble Visitor information
        $visitor = new GoogleAnalytics\Visitor();
        $visitor->setIpAddress($_SERVER['REMOTE_ADDR']);
        $visitor->setUserAgent($_SERVER['HTTP_USER_AGENT']);
        $visitor->setScreenResolution('1024x768');

        // Assemble Session information
        $session = new GoogleAnalytics\Session();

        // Assemble Page information
        $page = new GoogleAnalytics\Page($this->resource);
        $page->setTitle('CodePen AwesomePI');

        // Track page view
        $tracker->trackPageview($page, $session, $visitor);
    }
}