<?php
// Creating a connection to the database 
$host = 'localhost';
$username = 'lab5_user'; /// replace with your username
$password = 'password123';    //this too replave with your password
$dbname = 'group3';// same here replace with your dbname

// Create the connection to the database
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check connection to the database
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query to fetch data from the database
$sql = "SELECT `item Name`, `Total Sold`, `Total Remaining` FROM `inventory`";
$results = mysqli_query($conn, $sql);

// th ese are the variables to hold the database data 
$labels = [];
$soldData = [];
$remainingData = [];

while ($row = mysqli_fetch_assoc($results)) {
    $labels[] = $row['item Name'];
    $soldData[] = $row['Total Sold'];
    $remainingData[] = $row['Total Remaining'];
}

// Closes the connection to the database
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">

    <title>Chart</title>
</head>

<body id="reportspage">
  <div class="report-Container">
     
     <!-- this represents the container for the bar chart-->
     <div class="chart-container">
      <h1>Sales Report</h1>
        <div class="chart">
          <span>Monthly Earning Trends</span>
            <canvas id="myChart"></canvas>
        </div>
     </div>
    
     <div> 
       <p class="idf"></p>
     </div>
     
     
     <div class="charts-container">
     
        <div class="chart2">
          <span>Total income Per item</span>
            <canvas id="myChart2"></canvas>
        </div>
        
        <div class="chart2">
          <span>Revenue Breakdown</span>
            <canvas id="myChart3"></canvas>
        </div>
     </div>
  </div>

    <script>

     
        const ctx = document.getElementById('myChart');
        const labels = <?php echo json_encode($labels); ?>;
        const soldData = <?php echo json_encode($soldData); ?>;
        const remainingData = <?php echo json_encode($remainingData); ?>;
        
        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['jan','feb','march','april','may','june'],
                    datasets: [{
                        label: '# of revenue per month',
                        data: soldData,
                        borderWidth: 1,
                        backgroundColor: [
                            'red', 'green', 'blue', 'yellow', 'purple', 'orange'
                        ],
                        borderColor: 'black',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

     
        const ctx2 = document.getElementById('myChart2');
        if (ctx2) {
            new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Revenue per Item',
                        data: soldData,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        const ctx3 = document.getElementById('myChart3');
        if (ctx3) {
            new Chart(ctx3, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Revenue Breakdown',
                        data: remainingData,  // Use remainingData for pie chart
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script> 
</body>
</html>
