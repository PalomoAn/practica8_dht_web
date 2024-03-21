<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="60">
    <title>practica 08 webserver personal</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            text-align: center; /* Center align the content */
        }
        #chartContainer {
            display: inline-block; /* Make container inline-block to center it */
            text-align: left; /* Left align content within the container */
            margin-top: 20px; /* Add margin at the top */
        }
    </style>
</head>
<body>

<h1>Informacion Sensor Temperatura</h1> <!-- Centered title at the top -->

<div id="chartContainer">
    <canvas id="dataChart" style="width:800px; height:400px;"></canvas> <!-- Set canvas size -->
</div>

<script>
    // Fetch data from PHP file
    var allData = <?php include 'data_fetch.php'; ?>;

    // Initialize chart with all data
    var ctxData = document.getElementById("dataChart");
    var dataConfig = {
        type: 'line',
        data: {
            labels: allData.map(function(item) { return item.logdate; }), // Labels for all data points (using logdate)
            datasets: [{
                label: 'Temperatura',
                borderColor: 'rgba(154, 21, 7, 1)',
                backgroundColor: 'rgba(154, 21, 7, 0.2)',
                data: allData.map(function(item) { return item.temperature; })
            },
            {
                label: 'Humedad',
                borderColor: 'rgba(7, 42, 154, 1)',
                backgroundColor: 'rgba(7, 42, 154, 0.2)',
                data: allData.map(function(item) { return item.humidity; })
            },
            {
                label: 'Presion',
                borderColor: 'rgba(0, 128, 0, 1)',
                backgroundColor: 'rgba(0, 128, 0, 0.2)',
                data: allData.map(function(item) { return item.pressure; })
            },
            {
                label: 'Luz',
                borderColor: 'rgba(255, 215, 0, 1)',
                backgroundColor: 'rgba(255, 215, 0, 0.2)',
                data: allData.map(function(item) { return item.light; })
            }]
        },
        options: {
            responsive: false,
            title: {
                display: true,
                text: 'Sensor Data'
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Timestamp'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Value'
                    }
                }]
            }
        }
    };

    var dataChart = new Chart(ctxData, dataConfig);
</script>

    <div class="footer">
        <div class="footertxt"> 20380429 </div>
    </div>

</body>
</html>
