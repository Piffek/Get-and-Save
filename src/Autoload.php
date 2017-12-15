<?php
function __autoload($className)
{
    if (file_exists($className.'.php')) {
        require_once __DIR__.'/'.$className.'.php';

        return true;
    }

    return false;
}

?>