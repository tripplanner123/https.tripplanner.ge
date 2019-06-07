<?php defined('DIR') OR exit ?>

<?

class cart

{ 

	function get_sess()	{

		return session_id( );

	}



	function check_item($pid){

		$query = "SELECT * FROM ".c("table.cart")." WHERE session='".$this->get_sess()."' AND pid='$pid' "; 

		$result = mysql_query($query); 

	

		if(!$result) { 

			return 0; 

		} 

	

		$numRows = mysql_num_rows($result); 

	

		if($numRows == 0) { 

			return 0; 

		} else { 

			$row = mysql_fetch_array($result); 

			return $row['quantity']; 

		} 

	} 



	function add($pid, $quantity, $price) { 


		$qty = $this->check_item($pid); 

		if($quantity == 0) { 

			$query  = "delete from ".c("table.cart")." where pid='$pid' "; 

			mysql_query($query); 

		} else {

			if($qty == 0) { 

				$query  = "INSERT INTO ".c("table.cart")." (session, pid, quantity, price) VALUES "; 

				$query .= "('".$this->get_sess()."', '$pid', '$quantity', '$price') "; 

				mysql_query($query); 

			} else { 

//			$quantity += $qty; 

				$query  = "UPDATE ".c("table.cart")." SET quantity='$quantity' WHERE session='".$this->get_sess()."' AND "; 

				$query .= "pid='$pid' "; 

				mysql_query($query); 

			} 

		}

	} 



	function remove($pid) { 

		$query = "DELETE FROM ".c("table.cart")." WHERE session='".$this->get_sess()."' AND pid='$pid' "; 

		mysql_query($query); 

	} 



	function modify_quantity($pid, $quantity) { 

		$query = "UPDATE ".c("table.cart")." SET quantity='$quantity' WHERE session='".$this->get_sess()."' "; 

		$query .= "AND pid='$pid' "; 

		mysql_query($query); 

	} 



	function clear() { 

		$query = "DELETE FROM ".c("table.cart")." WHERE session='".$this->get_sess()."' "; 

		mysql_query($query); 

	} 



	function total() { 

		$result = mysql_query("SELECT sum(price * quantity) as price FROM ".c("table.cart")." WHERE ".c("table.cart").".session='".$this->get_sess()."' "); 

		$row = mysql_fetch_array($result);

		return $row['price']; 

	} 



	function tcount() { 

		$result = mysql_query("SELECT sum(quantity) as cnt FROM ".c("table.cart")." WHERE ".c("table.cart").".session='".$this->get_sess()."' "); 

		$row = mysql_fetch_array($result);

		return $row['cnt']; 

	} 



	function contents()	{

		$count = 0; 

		$query = "SELECT * FROM ".c("table.cart")." WHERE session='".$this->get_sess()."'"; 

		$result = mysql_query($query); 

		while($row = mysql_fetch_array($result)) { 

			$query = "SELECT * FROM product WHERE pid='".$row['pid']."' "; 

			$result_inv = mysql_query($query); 

			$row_inventory = mysql_fetch_array($result_inv); 

			$contents[$count]["pid"] = $row_inventory['pid']; 

			$contents[$count]["price"] = $row_inventory['price']; 

			$contents[$count]["quantity"] = $row['quantity']; 

			$contents[$count]["total"] = ($row_inventory['price'] * $row['quantity']); 

			$contents[$count]["description"] = $row_inventory['description']; 

			$contents[$count]["title"] = $row_inventory['title']; 

			$contents[$count]["author"] = $row_inventory['author']; 

			$count++; 

		} 

		return $contents; 

	} 



	function num_items() { 

		$query = "SELECT * FROM ".c("table.cart")." WHERE session='".$this->get_sess()."' "; 

		$result = mysql_query($query); 

		$num_rows = mysql_num_rows($result); 

		return $num_rows; 

	} 



	function quant() { 

		$query = "SELECT sum(quantity) as quantity FROM ".c("table.cart")." WHERE session='".$this->get_sess()."' "; 

		$result = mysql_query($query); 

		$row = mysql_fetch_array($result);

		return $row['quantity']; 

	}

}

?>





