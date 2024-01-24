<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speedtest Results</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        td a {
            color: #0000cc;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Speedtest Results</h1>
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
            $csv_file = file("speedtest_results.csv");
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
</body>
</html>
