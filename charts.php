<?php

include('parse.php');

?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">

    <title>Charts and stuff</title>

    <!-- Jquery Lib -->
    <script type="text/javascript" src="//code.jquery.com/jquery-1.9.1.js"></script>

    <!-- HighCharts Lib -->
    <script src="http://code.highcharts.com/highcharts.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>

</head>
<body>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        title: {
            text: 'Hashrate 5m',
            x: -20 //center
        },
        subtitle: {
            text: 'Source: Log File',
            x: -20
        },
        xAxis: {
            categories: [<?php
                $i = 0;
                foreach ($data['hashrate5m'] as $key => $val) {
                    $i++;
                    echo '"' . date('Y-m-j G:i', $key) . '"';
                    if ($i < count($data['hashrate5m'])) {
                        echo ',';
                    }
                }
            ?>]
        },
        yAxis: {
            title: {
                text: 'THs'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: 'TH'
        },
        legend: {
            layout: 'vertical',
            align: 'center',
            verticalAlign: 'bottom',
            borderWidth: 0
        },
        series: [{
            name: 'Hashrate',
            data: [<?php echo implode(',', $data['hashrate5m']); ?>]
        }]
    });
});
</script>
</body>
</html>
