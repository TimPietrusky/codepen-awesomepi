<?php

include_once('simplehtmldom/simple_html_dom.php');

/**
 *
 *
 * 2013 by timpietrusky.com
 *
 * Licensed under VVL 1.33b7 - timpietrusky.com/license
 */
class PenList {

    protected $output = array();
    protected $html;

    const VALUE_TYPE_ATTRIBUTE = 'attribute',
          VALUE_TYPE_PLAINTEXT = 'plaintext';

    function __construct() {
        $url = "";

        // User
        $user = Master::$Request->getA(true);
        // type
        $type = Master::$Request->getB();
        // sort order
        $sort_order = Master::$Request->getD();
        // page
        $page = Master::$Request->getE();

        $url = Config::getConfig()->codepen . "/$user/next_grid?type=$type&pen_grid_type=list&sort_order=$sort_order&page=$page&size=large";

        // Get JSON from CodePen
        $ch = curl_init(); 

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        // Timeout after 5 seconds
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $content_json = curl_exec($ch);
        curl_close($ch);

        // Decode the delivered JSON
        $output = json_decode($content_json, true);
        
        if (isset($output['html'])) {
            // Create a DOM object from a string
            $this->html = str_get_html($output['html']);
        } else {
            // Error
            
            // @TODO: Add a custom error
            Master::$Response->error();
            Master::$Response->getOutput();
            die();
        }
    }

    /**
     * Creates the output.
     *
     * @return Array $output
     */
    public function getOutput() {
        // Get all pens
        $pens = $this->html->find('div[class="pen-in-list-view"]');
        $pens_count = count($pens);

        // Has pens
        if ($pens_count > 0) {
            // Extract the info of every single pen
            for ($i = 0; $i < $pens_count; $i++) {
                // Title
                $this->output['pens'][$i]['title'] = $this->getValue($pens[$i], 'h2 a', NextGrid::VALUE_TYPE_PLAINTEXT);

                // Description
                $this->output['pens'][$i]['description'] = $this->getValue($pens[$i], 'h2', NextGrid::VALUE_TYPE_ATTRIBUTE, 'title');

                // Last updated
                $this->output['pens'][$i]['last_updated'] = $this->getValue($pens[$i], 'time', NextGrid::VALUE_TYPE_PLAINTEXT);

                // Comments
                $this->output['pens'][$i]['comments'] = $this->getValue($pens[$i], '.stats span[class=stat-value]', NextGrid::VALUE_TYPE_PLAINTEXT, "", 0);

                // Views
                $this->output['pens'][$i]['views'] = $this->getValue($pens[$i], '.stats span[class=stat-value]', NextGrid::VALUE_TYPE_PLAINTEXT, "", 1);

                // Hearts
                $this->output['pens'][$i]['hearts'] = $this->getValue($pens[$i], '.stats span[class=stat-value]', NextGrid::VALUE_TYPE_PLAINTEXT, "", 2);

                // URL - hash
                $url = $this->getValue($pens[$i], 'h2 a', NextGrid::VALUE_TYPE_ATTRIBUTE, 'href');
                $url = explode('/', $url);
                $hash = $url[count($url) - 1];
                $base_url = Config::getConfig()->codepen . '/' . Master::$Request->getA(true) . '/';

                // URL - pen
                $this->output['pens'][$i]['url']['pen'] = $base_url . 'pen/' . $hash;

                // URL - details
                $this->output['pens'][$i]['url']['details'] = $base_url . 'details/' . $hash;
                
                // URL - full
                $this->output['pens'][$i]['url']['full'] = $base_url . 'full/' . $hash;

                // URL - fullgrid
                $this->output['pens'][$i]['url']['fullgrid'] = $base_url . 'fullgrid/' . $hash;

                // Hash
                $this->output['pens'][$i]['hash'] = $hash;
            }
        }
        
        return $this->output;
    }

    /**
     * Returns the value of the found element <CODE>$toFind</CODE>
     * with the type <CODE>$type</CODE>.
     *
     * If <CODE>$type</CODE> is <CODE>NextGrid::VALUE_TYPE_ATTRIBUTE</CODE>,
     * then the attribute-name <CODE>$attribute</CODE> must be specified.
     *
     * @param simple_html_dom_node $pen
     * @param String $toFind
     * @param String $type
     * @param String $attribute
     *
     * @return mixed $value
     */
    protected function getValue($pen, $toFind, $type, $attribute = "", $position = 0) {
        $value = $pen->find($toFind);

        // Value is not null
        if (isset($value[$position])) {
            if ($type == PenList::VALUE_TYPE_ATTRIBUTE) {
                $value = $value[$position]->getAttribute($attribute);
            }

            if ($type == PenList::VALUE_TYPE_PLAINTEXT) {
                if (empty($value[$position]->plaintext) && isset($value[1])) {
                    $value = $value[1]->plaintext;
                } else {
                    $value = $value[$position]->plaintext;
                }
            }

            $value = trim($value);

            // Convert numbers
            if (is_numeric($value)) {
                $value = intval($value);
            }
        // Value is null / not set / not available
        } else {
            $value = Config::getConfig()->default_value_null;
        }

        return $value;
    }    
}