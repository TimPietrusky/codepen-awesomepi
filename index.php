<?php

/**
 * CodePen-AwesomePI
 *
 * An off the record API for CodePen to retrieve all the awesome pens.
 * (This API is not official, it's just a fan made thing)
 *
 * 
 * https://github.com/TimPietrusky/codepen-awesomepi
 *
 *
 * 2012 - 2014 by timpietrusky.com
 *
 * Licensed under VVL 1.33b7 - timpietrusky.com/license
 */

require_once "app/Master.php";

/*
if (isset($_REQUEST['test'])) {
    require_once "app/core/Test.php";
    die();
}
*/

// Burn baby, burn
Master::run();

?>