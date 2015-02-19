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

$logFile = file_get_contents('ckproxy.log');

$data = array(
    'hashrate5m' => array(),
    // 'sps5m' => array(), // we can make a chart for shares per second
);
foreach(preg_split("/((\r?\n)|(\r\n?))/", $logFile) as $line){
    if (strpos($line, 'Pool:') !== false) {

        // Time
        preg_match('~\[(.*?)\]~', $line, $dateTime);
        $line = str_replace($dateTime[0], '', $line);
        $lineTime = strtotime($dateTime[1]);

        // Identify start of json
        $line = trim(ltrim(strstr($line, ':'), ':'));
        $lineData = json_decode($line, true);

        // Format array of data based on what we have/want
        if ($lineData['hashrate5m']) { // only save hashrate data if that's what this line is
            end($data['hashrate5m']);
            if (empty($data['hashrate5m']) || key($data['hashrate5m']) <= ($lineTime-300)) {
                $data['hashrate5m'][$lineTime] = hashparse($lineData['hashrate5m']);
            }
        }
    }
}

?>
