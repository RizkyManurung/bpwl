<?php
$conn = new mysqli("localhost", "root", "", "grafik_atlet");
if ($conn->connect_errno) {
    echo die("Failed to connect to MySQL: " . $conn->connect_error);
}
 
$rows = array();
$table = array();
$table['cols'] = array(
	array('label' => 'Cabang Olahraga yang diikuti', 'type' => 'string'),
	array('label' => 'Jumlah Atlet dari cabang olahraga', 'type' => 'number')
);
 
$sql = $conn->query("SELECT * FROM users");

while($data = $sql->fetch_assoc()){
	$temp = array();
	$temp[] = array('v' => (string)$data['cabang_olahraga']);
	$temp[] = array('v' => (int)$data['jml_atlet']);
	$rows[] = array('c' => $temp);
}

$table['rows'] = $rows;
$jsonTable = json_encode($table);
 
?>
<html>
<head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
 
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);
 
	function drawChart() {
		var data = new google.visualization.DataTable(<?php echo $jsonTable; ?>);
 
		var options = {'title':'Data Atlet',
					   'width':800,
					   'height':700};
 
		var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
		chart.draw(data, options);
	}
    </script>
</head>
<body>
    <div id="chart_div"></div>
	
</body>
</html>
