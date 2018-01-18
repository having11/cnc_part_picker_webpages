<!DOCTYPE html>
<html>
<head>
<style>
	#search_table{
		width: 100%;
		padding: 10px;
		background-color: white;
		font-family: "Verdana", Arial, Helvetica;
	}
	
	
	#th_search{
		text-align: left;
		background-color: dimgray;
		color:white;
	}
	
</style>
</head>
<body>
<?php
	$q = $_GET['q'];
	$valArray = explode(',',$q);
	if($valArray[0]=="quick_add"){
		$conn = new mysqli('IP','username','password','components');
		$current_quantity = $conn->query("SELECT * FROM parts WHERE id=".(int)$valArray[2] . " AND owner='" . $valArray[3] . "'");
		$current_quantity = $current_quantity->fetch_assoc()['quantity'];
		$current_quantity = (int)$current_quantity;
		if($valArray[1]=="add"){
		$conn->query("UPDATE parts SET quantity=".($current_quantity+1) . " WHERE id=".(int)$valArray[2] . " AND owner='" . $valArray[3] . "'");
		}
		else if($valArray[1]=="subtract"){
			$conn->query("UPDATE parts SET quantity=".($current_quantity-1) . " WHERE id=".(int)$valArray[2] . " AND owner='" . $valArray[3] . "'");
		}
	}
		
	else{
	$conn = new mysqli('IP','username','password','components');
	if($valArray[0]=="id"){
	$sql = "SELECT * FROM parts WHERE id='".$valArray[1]."'";
	}
	else if($valArray[0]=="name"){
	$sql = "SELECT * FROM parts WHERE name LIKE '%".$valArray[1]."%'";
	}
	else if($valArray[0]=="category"){
		$sql = "SELECT * FROM parts WHERE category LIKE '%".$valArray[1]."%'";
	}
	$sql .= " AND owner='" . $valArray[2] . "'";
	$result = $conn->query($sql);
	echo '<table class="db-table" id="search_table">
	<tr>
	<th id="th_search">ID</th>
	<th id="th_search">Name</th>
	<th id="th_search">Category</th>
	<th id="th_search">Quantity</th>
	</tr>';
	while($row = $result->fetch_assoc()){
		echo "<tr>";
		echo "<td>" . $row['id'] . "</td>";
		echo "<td>" . $row['name'] . "</td>";
		echo "<td>" . $row['category'] . "</td>";
		echo "<td>" . $row['quantity'] . "</td>";
		echo "</tr>";
	}
	echo "</table>";
	}
	$conn->close();
?>
	
	
	
</body>


</html>