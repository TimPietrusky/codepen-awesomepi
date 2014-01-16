<?php

/**
 * Handles the API-Response.
 *
 * 
 * https://github.com/TimPietrusky/codepen-awesomepi
 *
 *
 * 2012 - 2014 by timpietrusky.com
 *
 * Licensed under VVL 1.33b7 - timpietrusky.com/license
 */
class Response {
    protected $status;
    protected $status_message;

    function __construct() {}



    /**
     * Create an error response (e.g. caused by an invalid API-Request)
     */
    public function error() {
        $this->status = Config::getConfig()->response_status_error;
        $this->status_message = Config::getConfig()->response_status_error_message;
    }

    /**
     * Set the response-output based on the <CODE>$response</CODE> Array.
     *
     * @param Array $response
     */
    public function setResponse($response) {
        $this->status = Config::getConfig()->response_status_success;
        $this->status_message = Config::getConfig()->response_status_success_message;

        $this->output = $response;
    }

    /**
     * Creates the JSON header and output.
     */
    public function getOutput() {
        if (!isset($this->output) || count($this->output) == 0) {
            $this->output = null;
        }

        $output = array(
            'status' => array(
                'code' => $this->status,
                'message' => $this->status_message
            ),
            'content' => $this->output
        );

        // JSON header
        $this->getHeader();

        // JSONP output
        if (isset($_REQUEST['jsonp'])) {
            echo $_REQUEST['jsonp'] . '(' . json_encode($output) . ')';

        // JSON output
        } else {
            echo json_encode($output);
        }
    }

    /**
     * Sets the JSON header.
     */
    protected function getHeader() {
        header('Content-type: application/json');
    }
}

?>