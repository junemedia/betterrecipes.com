<?php

define('ADMIN_USERNAME','leonzw');     // Admin Username
define('ADMIN_PASSWORD','woaititan');      // Admin Password

////////// END OF DEFAULT CONFIG AREA /////////////////////////////////////////////////////////////

///////////////// Password protect ////////////////////////////////////////////////////////////////
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
           $_SERVER['PHP_AUTH_USER'] != ADMIN_USERNAME ||$_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD) {
            Header("WWW-Authenticate: Basic realm=\"Login check!\"");
            Header("HTTP/1.0 401 Unauthorized");

            echo <<<EOB
                <html><body>
                </body></html>
EOB;
            exit;
}

?>