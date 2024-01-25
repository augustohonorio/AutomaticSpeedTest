<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speedtest Results</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
	    width: 100%;
	    box-sizing: border-box;
        }

        canvas {
            width: 100%;
            max-width: 1500px;
            height: auto;
            max-height: 300px;
	    margin: 0 auto;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            overflow-x: auto;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4caf50;
            color: white;
        }

        td a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        td a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Speedtest Results</h1>
    <canvas id="speedChart"></canvas>
    <table>
        <tr>
            <th>Timestamp</th>
            <th>Server</th>
            <th>Idle Latency</th>
            <th>Download</th>
            <th>Upload</th>
            <th>Packet Loss</th>
            <th>Result URL</th>
        </tr>
        <?php
            $csv_file = array_reverse(file("speedtest_results.csv"));
            foreach ($csv_file as $line) {
                $data = explode(",", $line);
                echo "<tr>";
                foreach ($data as $index => $value) {
                    // Convert Result URL to a hyperlink
                    if ($index === 6 && !empty($value)) {
                        echo "<td><a href=\"$value\" target=\"_blank\">View In Site SpeedTest</a></td>";
                    } else {
                        echo "<td>$value</td>";
                    }
                }
                echo "</tr>";
            }
        ?>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var csvData = <?php echo json_encode(array_reverse(file("speedtest_results.csv"))); ?>;

        var chartData = {
            labels: [],
            datasets: [
                {
                    label: 'Download Speed (Mbps)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 3,
                    data: []
                },
                {
                    label: 'Upload Speed (Mbps)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 3,
                    data: []
                }
            ]
        };
        csvData.forEach(function (line) {
            var data = line.split(",");
            chartData.labels.push(data[0]);
            chartData.datasets[0].data.push(parseFloat(data[3]));
            chartData.datasets[1].data.push(parseFloat(data[4]));
        });

        var chartOptions = {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        var ctx = document.getElementById('speedChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: chartOptions
        });
    </script>
</body>
</html>
