<?php
    function isSessionSet()
    {        
        return session_status() == PHP_SESSION_NONE;
    }
?>