<?php

class Master {

    private static $base_path;

    public static $Config;
    public static $Request;
    public static $Response;



    function __construct() {}

    public static function run() {
        // Set the include path
        set_include_path(self::loadIncludePath());

        // "Auto"-include :D
        self::auto_include();

        // Load configuration
        self::$Config = Config::run();

        // Handles the api-request
        self::handleRequest();
    }

    /**
     * Set the include path.
     */
    protected static function loadIncludePath() {
        self::$base_path = getcwd();
        $include_path = "";

        $includes = array(
                'app',
                'app/core',
                'app/plugins'
        );

        foreach ($includes as $toInclude) {
            $include_path .= self::$base_path . '/' . $toInclude . PATH_SEPARATOR;
        }

        $include_path .= PATH_SEPARATOR . get_include_path();

        return $include_path;
    }

    /**
     * A kind of automatic <CODE>include_once()</CODE> of all
     * required Classes.
     */
    protected static function auto_include() {
        $includes = array(
            'NextGrid',
            'Pen',
            'PenList',
            'Request',
            'Response',
            'Config'
        );

        foreach ($includes as $include_me) {
            include_once('core/'.$include_me.'.php');
        }
    }

    /**
     * Handles an API-Request and creates the suitable Response.
     */
    protected static function handleRequest() {
        self::$Request = new Request();
        self::$Response = new Response();

        // Handle the different request types
        switch (self::$Request->getA()) {
            // user
            case 'user':
                if (self::$Request->isValid()) {

                    if (in_array(self::$Request->getB(), explode("|", Config::getConfig()->request_b_specific))) {
                        $Pen = new Pen();
                        self::$Response->setResponse($Pen->getOutput());
                    } else if (in_array(self::$Request->getC(), explode("|", Config::getConfig()->request_c_user))) {
                        $PenList = new PenList();
                        self::$Response->setResponse($PenList->getOutput());
                    } else {
                        $NextGrid = new NextGrid();
                        self::$Response->setResponse($NextGrid->getOutput());
                    }

                    break;
                } else {
                    self::$Response->error();
                    break;
                }

            // home
            case 'home':
                $NextGrid = new NextGrid();
                self::$Response->setResponse($NextGrid->getOutput());
                break;

            // error
            default:
                self::$Response->error();
                break;
        }

        // Output JSON
        self::$Response->getOutput();
    }
}