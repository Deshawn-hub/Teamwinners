<?php
// Creating a connection to the database 
$host = 'localhost';
$username = 'shawn';/// this should be changed to match your dadtabse
$password = 'passwordes'; //this also
$dbname = 'group4';// also this

$conn = mysqli_connect($host,$username,$password,$dbname);
$sql = "SELECT `item Name`, `Total Sold`, `Tolal Remaining` FROM `inventory`";
$results = mysqli_query($conn,$sql);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Creating the variables to hold the database data 
$labels = [];
$solddata = [];
$remainingData = [];

while ($row = mysqli_fetch_assoc($results)) {
    $labels[] = $row['item Name'];
    $solddata[] = $row['Total Sold'];
    $remainingData[] = $row['Tolal Remaining'];
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <title>Chart</title>
</head>
<body id="reportspage">
  <div class="report-Container">
     
     <!-- this represents the container for the bar chart, it takes up the full width of the top page -->
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
     
     <!-- this is the line and pie chart container, they are side by side --> 
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
        // For Bar chart
        const ctx = document.getElementById('myChart');
        // Assigning PHP data to JS variables
        const labels = <?php echo json_encode($labels); ?>;
        const solddata = <?php echo json_encode($solddata); ?>;
        const remainingData = <?php echo json_encode($remainingData); ?>;

        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan','Feb','Mar','Apr','May','June','July'],
                    datasets: [{
                        label: '# of revenue',
                        data: [10000,20000,5000,45000,60000,10000,30000], // Data for sales
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

        // For Line chart
        const ctx2 = document.getElementById('myChart2');
        if (ctx2) {
            new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '# of revenue',
                        data: solddata, // Use sold data for this chart as well
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

        // For Pie chart
        const ctx3 = document.getElementById('myChart3');
        if (ctx3) {
            new Chart(ctx3, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: '# of revenue',
                        data: remainingData, // Use remaining data for pie chart
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                    }
                }
            });
        }
    </script> 
</body>
</html>
