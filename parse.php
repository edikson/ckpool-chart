<?php

function hashparse($hashrate){
    if (substr($hashrate, -1) == 'K'){
        return (preg_replace('/[^0-9.]/', '', $hashrate) * 1000);
    }
    else if (substr($hashrate, -1) == 'M'){
        return (preg_replace('/[^0-9.]/', '', $hashrate) * 1000000);
    }
    else if (substr($hashrate, -1) == 'G'){
        return (preg_replace('/[^0-9.]/', '', $hashrate) * 1000000000);
    }
    else if (substr($hashrate, -1) == 'T'){
        return (preg_replace('/[^0-9.]/', '', $hashrate) * 1000000000000);
    }
    else if (substr($hashrate, -1) == 'P'){
        return (preg_replace('/[^0-9.]/', '', $hashrate) * 1000000000000000);
    }
    else if (substr($hashrate, -1) == 'E'){
        return (preg_replace('/[^0-9.]/', '', $hashrate) * 1000000000000000000);
    }
    else {
        return (preg_replace('/[^0-9.]/', '', $hashrate));
    }
}

$logFile = fopen('ckproxy.log', 'r');

$pos = -2;
$maxvalues = 60;
$lines = array();
$currentLine = '';
$line = '';

$data = array(
    'hashrate1m' => array(),
    // 'sps5m' => array(), // we can make a chart for shares per second
);
while ((-1 !== fseek($logFile, $pos, SEEK_END)) && ($maxvalues > 0)){
    $char = fgetc($logFile);
    if (PHP_EOL == $char) {
            $line = $currentLine;
            $currentLine = '';
    } else {
            $line = "";
            $currentLine = $char . $currentLine;
    }

    if ((strpos($line, 'Pool:') !== false) && (strpos($line, 'hashrate1m') !== false)) {

        // Time
        preg_match('~\[(.*?)\]~', $line, $dateTime);
        $lineTime = strtotime($dateTime[1]);

        // Identify start of json
        $line = trim(ltrim(strstr($line, 'Pool:'), 'Pool:'));
        $lineData = json_decode($line, true);

        // Format array of data based on what we have/want
        if ($lineData['hashrate1m']) { // only save hashrate data if that's what this line is
            $data['hashrate1m'][$lineTime] = hashparse($lineData['hashrate1m']);
            $maxvalues--;
        }
    }
    $pos--;
}

?>
