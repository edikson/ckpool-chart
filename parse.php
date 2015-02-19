<?php

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
                $data['hashrate5m'][$lineTime] = preg_replace('/[^0-9.]/', '', $lineData['hashrate5m']);
            }
        }
    }
}

?>
