<?php

/**
 * Holds and handles the configuration.
 *
 *
 * 2012 by timpietrusky.com
 *
 * Licensed under VVL 1.33b7 - timpietrusky.com/license
 */
final class Config {

    // Config
    public static $config = array(
        'codepen' => 'http://codepen.io',

        'request_a' => 'picks|popular|recent',
        'request_b_user' => 'owned|love|loved|forked|pen|details',
        'request_b_specific' => 'pen|details',

        // Request types
        'type_user' => 'user',
        'type_home' => 'home',
        'type_none' => 'none',
        'type_pen'  => 'pen',
        'type_details' => 'details',

        // Response codes & messages
        'response_status_success' => 0,
        'response_status_success_message' => 'ok',
        'response_status_error' => 1337,
        'response_status_error_message' => 'invalid',

        // Default null value
        'default_value_null' => null
    );

    private function __construct() {}



    /**
     * Initialize the config.
     *
     * @return Object $config
     */
    public static function run() {
        // Transform the stupid config-array into a handsome object
        self::$config = (object) self::$config;

        return self::getConfig();
    }

    /**
     * Returns the <CODE>$config</CODE>.
     *
     * @return Object $config
     */
    public static function getConfig() {
        return self::$config;
    }
}
?>