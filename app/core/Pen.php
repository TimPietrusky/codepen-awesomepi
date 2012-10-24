<?php

include_once('simplehtmldom/simple_html_dom.php');

/**
 * Gets the content from CodePen,
 * parses it with the help of "PHP Simple HTML DOM Parser" (http://sourceforge.net/projects/simplehtmldom/)
 * and returns the output as an array.
 *
 *
 * 2012 by timpietrusky.com
 *
 * Licensed under VVL 1.33b7 - timpietrusky.com/license
 */
class Pen {
    protected $output;
    protected $html;

    function __construct() {
        $A = Master::$Request->getA(true);
        $B = Master::$Request->getB(true);
        $C = Master::$Request->getC(true);
        $url = "";

        $url = Config::getConfig()->codepen . "/$A/$B/$C";

        // Get HTML from CodePen
        $ch = curl_init(); 
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        // Timeout after 5 seconds
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $content_html = curl_exec($ch);
        curl_close($ch);
        
        if (!empty($content_html)) {
            // Create a DOM object from a string
            $this->html = str_get_html($content_html);

            // Check if pen-id is not valid
            $notValid = $this->html->find('img[src=/images/404.png]');
            $notValid = isset($notValid[0]);

            if ($notValid) {
            	// Error
	            Master::$Response->error();
	            Master::$Response->getOutput();
	            die();

	        // Valid request
            } else {

                // pen
                if (Master::$Request->getB() == Config::getConfig()->type_pen) {
                    $this->getPen();
                // details
                } else {
                    die("not implemented yet :(");
                }

                $this->addUrls();
            }
        } else {
            // Error
            
            // @TODO: Add a custom error
            Master::$Response->error();
            Master::$Response->getOutput();
            die();
        }
    }

    public function getOutput() {
    	return $this->output;
    }

    /**
     * Get the source & tags of a specific pen.
     */
    protected function getPen() {
        $content = $this->html->find('script', 3)->innertext; 
        
        // Extract the content
        $content = split('__pen =', $content);
        $content = split('; __tags =', $content[1]);

        // HTML/CSS/JS
        $content_pen = $content[0];
        // Decode json
        $content_pen = json_decode($content_pen, true);
        // Remove unnecessary elements
        unset($content_pen['id'], $content_pen['parent'], $content_pen['session_hash'], $content_pen['slug'], $content_pen['user_id']);

        // Tags
        $content_tags = split('; __user =', $content[1]);
        $content_tags = trim($content_tags[0]);
        $content_tags = str_replace(array('["', '"]'), '', $content_tags);
        $content_tags = split('","', $content_tags);

        // Add 'pen' to output
        $this->output['pen'] = $content_pen;

        // Add 'tags' to output
        $this->output['tags'] = $content_tags;
    }

    protected function getDetails() {
    }

    protected function addUrls() {
        $C = Master::$Request->getC(true);
        
        // URL - pen
        $this->output['pen']['url']['pen'] = Config::getConfig()->codepen . "/pen/$C";

        // URL - details
        $this->output['pen']['url']['details'] = Config::getConfig()->codepen . "/details/$C";
        
        // URL - full
        $this->output['pen']['url']['full'] = Config::getConfig()->codepen . "/full/$C";

        // URL - fullgrid
        $this->output['pen']['url']['fullgrid'] = Config::getConfig()->codepen . "/fullgrid/$C";
    }
}

?>