<?php
	$q = $_GET['username'];
	$conn = new mysqli('IP','username','password','components');
		echo '<br><h3>Parts List</h3>';
		$result2 = $conn->query("SELECT * FROM parts ORDER BY category");
		echo '<table class="db-table" id="large_table">';
		echo '<tr><th>Id</th><th>Category</th><th>Name</th><th>Quantity</th></tr>';
		while($row2 = $result2->fetch_assoc()){
			if($row2['owner']==$q){
				echo '<tr>';
			foreach($row2 as $key=>$value){
					if($key=="owner"){
						
					}
					else{
						echo '<td>',$value,'</td>';
					}
				}
				echo '</tr>';
			}
		}
		echo '</table>';
$conn->close();

?>