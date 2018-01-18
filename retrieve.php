<?php 
    $q = $_GET['q'];
    if(strpos($q,'load_cats')!==false){
		$valArray = explode(',',$q);
        $conn = new mysqli('IP','username','password','components');
        $result = $conn->query("SELECT * FROM categories WHERE owner='" . $valArray[1] . "' ORDER BY name");
		if($valArray[2]=="true"){
        echo '<select class="drop_down" name="drop_down" id="drop_down_id" onchange="load_parts_from_cat(this.value);">'.
            '<option value="">Please select a category below</option>';
		}
		else if($valArray[2]=="false"){
			echo '<select class="drop_down" name="cat_name" id="drop_down_id">'.
            '<option value="">Please select a category below</option>';
		}
            while($row = $result->fetch_assoc()){
                echo '<option value="' . $row["name"] . '">' . $row["name"] . '</option>';
            }
            echo '</select>';
    }
    else if(strpos($q,'load_parts')!==false){
        $valArray = explode(',',$q);
        $conn = new mysqli('IP','username','password','components');
        $result = $conn->query("SELECT * FROM parts WHERE category='" . $valArray[1] . "'");
        echo '<select class="drop_down" name="drop_down_parts"><option value="">Please select a part below</option>';
            while($row = $result->fetch_assoc()){
                echo '<option value="' . $row["name"] . '">' . $row["name"] . '</option>';
            }
            echo '</select>';
    }
    else if(strpos($q,'change_amt')!==false){
        $valArray = explode(',',$q);
        $conn = new mysqli('IP','username','password','components');
		if($valArray[3]=="Change"){
        	$current_quantity = $conn->query("SELECT * FROM parts WHERE name='" . $valArray[1] . "'");
			$current_quantity = $current_quantity->fetch_assoc();
			$add_amt = (int)$valArray[2];
			$current_quantity = $current_quantity['quantity'];
        	$result = $conn->query("UPDATE parts SET quantity=" . ($current_quantity + (int)$valArray[2]) . " WHERE name='" . $valArray[1] . "' AND owner='" . $valArray[5] . "'");
			echo '<div style="display:inline-block">
			<h3 style="font-family:"Verdana";">Changed. New quantity: ' . ($current_quantity + (int)$valArray[2]) .'</h3>
			</div>';
		}
		else if($valArray[3]=="Add new"){
			$sql = "INSERT INTO parts (category, name, quantity, owner) VALUES ('" . $valArray[4] . "','" . $valArray[2] . "','0','" . $valArray[5] . "')";
			$result = $conn->query($sql);
			echo '<div style="display:inline-block">
			<h3 style="font-family:"Verdana";">Added</h3>
			</div>';
		}
		else if($valArray[3]=="Remove"){
			$sql = "DELETE FROM parts WHERE name='" . $valArray[1] . "' AND owner='" . $valArray[5] . "'";
			$result = $conn->query($sql);
			echo '<div style="display:inline-block">
			<h3 style="font-family:"Verdana";">Removed</h3>
			</div>';
		}
	}
	else if(strpos($q,'add_cat')!==false){
		$valArray = explode(',',$q);
		$conn = new mysqli('IP','username','password','components');
		$result = $conn->query("SELECT * FROM categories WHERE name='" . $valArray[1] . "' AND owner='" . $valArray[2] . "'");
		if($result->fetch_assoc()['name']==$valArray[1]){
			echo "Category already exists";
		}
		else{
		$result = $conn->query("INSERT INTO categories (name, owner) VALUES ('" . $valArray[1] . "','" . $valArray[2] . "')");
		echo "Added new category";
		}
	}
	else if(strpos($q,'remove_cat')!==false){
		$valArray = explode(',',$q);
		$conn = new mysqli('IP','username','password','components');
		$result = $conn->query("DELETE FROM parts WHERE category='" . $valArray[2] . "' AND owner='" . $valArray[1] . "'");
		$result = $conn->query("DELETE FROM categories WHERE name='" . $valArray[2] . "' AND owner='" . $valArray[1] . "'");
	}
	
$conn->close();
?>