<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="styles/graficestyle.css">
    <title>Grafic</title>
</head>
<body>
  <div class="container">
        <nav>
        <a href="index.php">Main</a>
        </nav>
    <h3>Exemple de Grafice</h3>
    <p>Line Chart</p>
  <canvas id="line-chart"></canvas>
  <hr>
  <p>Bar Chart</p>
  <canvas id="bar-chart"></canvas>
  <hr>
  <p>Pie Chart</p>
  <canvas id="pie-chart"></canvas>

<script>
        var ctx = document.getElementById('line-chart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Ian', 'Feb', 'Mar', 'Apr', 'Mai', 'Jun'],
                datasets: [{
                    label: 'Vanzari',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>



   <script>
    
    var barCtx = document.getElementById('bar-chart').getContext('2d');
    var barChart = new Chart(barCtx, {
      type: 'bar',
      data: {
        labels: ['Rosu', 'Albastru', 'Galben', 'Verde', 'Violet', 'Portocaliu'],
        datasets: [{
          label: 'Vanzari',
          data: [12, 19, 3, 5, 2, 3],
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
        }]
      },
      options: {}
    });
</script>

<script>
    // Get the canvas element
var canvas = document.getElementById('pie-chart');

// Create the data for the chart
var data = {
  labels: ['Rosu', 'Albastru', 'Galben', 'Verde', 'Violet', 'Portocaliu'],
  datasets: [{
    label: 'Vanzari',
    data: [12, 19, 3, 5, 2, 3],
    backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(255, 206, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(153, 102, 255, 0.2)',
      'rgba(255, 159, 64, 0.2)'
    ],
    borderColor: [
      'rgba(255, 99, 132, 1)',
      'rgba(54, 162, 235, 1)',
      'rgba(255, 206, 86, 1)',
      'rgba(75, 192, 192, 1)',
      'rgba(153, 102, 255, 1)',
      'rgba(255, 159, 64, 1)'
    ],
    borderWidth: 1
  }]
};


var options = {
  title: {
    display: true,
    text: 'Pie Chart'
  }
};


var pieChart = new Chart(canvas, {
  type: 'pie',
  data: data,
  options: options
});


</script>
</div>
</body>
</html>