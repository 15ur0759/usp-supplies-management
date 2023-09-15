<?php

function currentDate(){
date_default_timezone_set('Asia/Manila');

return date('Y-m-d h:i:s');

}

$now = currentDate();

