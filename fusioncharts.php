<?php
require_once 'header.php';
include 'classes/fusionchart.php';
include 'classes/fusionchart.class.php';
$newObj = new Queries();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
    <script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
    
</head>
<body>

<div class="fusionChartsDiv" style="overflow:auto; height: 1900px;">
<?php
    $currentYear = date("Y");
    $datesArray = array();
    $trends = array();
    $datesArray = $newObj->getDates();
    $purchases = $newObj->getYearlyIncome();
    $monthlyIncome = $newObj->getMonthlyPurchases();
    $trends = $newObj->getTopFiveTrends();


    // Widget appearance configuration
    $arrChartConfig = array(
        "chart" => array(
            "caption"       => "Yearly income chart",
            "subCaption"    => "E-commerce website 'CandyShop'",
            "xAxisName"     => "Year",
            "yAxisName"     => "Revenues (In EUR)",
            "numberPrefix"  => "€",
            "theme"         => "fusion"
        )
    );

    $arrLabelValueData = array();

    array_push($arrLabelValueData, array(
            "label" => $currentYear, "value" => $purchases
    ));
    
    $arrChartConfig["data"] = $arrLabelValueData;

    // JSON Encode the data to retrieve the string containing the JSON representation of the data in the array.
    $jsonEncodedData = json_encode($arrChartConfig);

    // Widget object
    $Widget = new FusionCharts("column2d", "MyFirstWidget", "400", "350", "widget-container", "json", $jsonEncodedData);

    // Render the Widget
    $Widget->render();

    ?>
    <center>
        <div id="widget-container">Widget will render here!</div>
    </center>

    <?php


    // Chart Configuration stored in Associative Array
    $arrChartConfig2 = array(
        "chart" => array(
            "caption"       => "Top 5 best selling products",
            "xAxisName"     => "Product name",
            "yAxisName"     => "Product bought quantity",
            "color"         => "#FFF123",
            "exportEnabled" => "1",
            "theme"         => "fusion"
        )
    );
    $arrLabelValueData2 = array();

    foreach($trends as $trend => $value) {
        array_push($arrLabelValueData2, array(
                "label" => $value['productName'], "value" => $value['purchasedProducts']
        ));
    }

    $arrChartConfig2["data"] = $arrLabelValueData2;

    $jsonEncodedData2 = json_encode($arrChartConfig2);

    $Chart = new FusionCharts("column2d", "Something", "1200", "500", "chart-container2", "json", $jsonEncodedData2);

    $Chart->render();
    ?>
    <center>
        <div id="chart-container2">Chart will render heres!</div>
    </center>


    <?php
    // Chart Configuration stored in Associative Array
    $arrChartConfig3 = array(
        "chart" => array(
            "caption"       => "Registered users by month",
            "subCaption"    => "",
            "xAxisName"     => "Month",
            "yAxisName"     => "Users count",
            "numberSuffix"  => "",
            "color"         => "#FFF123",
            "exportEnabled" => "1",
            "theme"         => "fusion"
        )
    );
    $arrLabelValueData3 = array();

    foreach($datesArray as $date => $value) {
        array_push($arrLabelValueData3, array(
                "label" => $value['Years'] . "-" . $value['Month'], "value" => $value['totalUsers']
        ));
    }

    $arrChartConfig3["data"] = $arrLabelValueData3;

    $jsonEncodedData3 = json_encode($arrChartConfig3);

    $Chart2 = new FusionCharts("column2d", "Something4", "1200", "500", "chart-container", "json", $jsonEncodedData3);

    $Chart2->render();
    ?>
    <center>
        <div id="chart-container">Chart will render here!</div>
    </center>


    <?php
    // Chart Configuration stored in Associative Array
    $arrChartConfig4 = array(
        "chart" => array(
            "caption"       => "Incomes by month",
            "subCaption"    => "",
            "xAxisName"     => "Month",
            "yAxisName"     => "Incomes",
            "numberSuffix"  => "",
            "color"         => "#FFF123",
            "exportEnabled" => "1",
            "theme"         => "fusion"
        )
    );
    $arrLabelValueData4 = array();

    foreach($monthlyIncome as $date => $value) {
        array_push($arrLabelValueData4, array(
                "label" => $value['month'], "value" => $value['monthlyIncome']
        ));
    }

    $arrChartConfig4["data"] = $arrLabelValueData4;

    $jsonEncodedData4 = json_encode($arrChartConfig4);

    $Chart3 = new FusionCharts("column2d", "Something3", "1200", "500", "chart-containers", "json", $jsonEncodedData4);

    $Chart3->render();
    ?>
    <center>
        <div id="chart-containers">Chart will render here!</div>
    </center>



</div>



</body>
</html>