<?php
include_once 'config.php';

function getConnection()
{
    global $HOST;
    global $USER;
    global $PASS;
    global $DB;
    global $PORT;

    return new mysqli($HOST, $USER, $PASS, $DB, $PORT);
}
