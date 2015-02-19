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
            labels: {
                formatter: function() {
                    var maxElement = this.axis.max;
                    if (maxElement > 1000000000000000000) {
                        return this.value / 1000000000000000000 + "E";
                    } else if (maxElement > 1000000000000000) {
                        return this.value / 1000000000000000 + "P";
                    } else if (maxElement > 1000000000000) {
                        return this.value / 1000000000000 + "T";
                    } else if (maxElement > 1000000000) {
                        return this.value / 1000000000 + "G";
                    } else if (maxElement > 1000000) {
                        return this.value / 1000000 + "M";
                    } else if (maxElement > 1000) {
                        return this.value / 1000 + "K";
                    } else {
                        return this.value;
                    }
                }
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
              formatter: function() {
                    if (this.y > 1000000000000000000) {
                        return this.y / 1000000000000000000 + "E";
                    } else if (this.y > 1000000000000000) {
                        return this.y / 1000000000000000 + "P";
                    } else if (this.y > 1000000000000) {
                        return this.y / 1000000000000 + "T";
                    } else if (this.y > 1000000000) {
                        return this.y / 1000000000 + "G";
                    } else if (this.y > 1000000) {
                        return this.y / 1000000 + "M";
                    } else if (this.y > 1000) {
                        return this.y / 1000 + "K";
                    } else {
                        return this.y;
                    }
                }
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
