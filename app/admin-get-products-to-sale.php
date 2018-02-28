<?php

include('controllers/db.php');

$response=array();

global $db;

if(isset($_REQUEST['branch_id'])){

		$shopId=$_REQUEST['branch_id'];
		
		//	$shopId = $db->GetOne("SELECT outlet_posted FROM `tb_employees` WHERE id=$user_id");

			$results=$db->GetArray("SELECT tb_products.product_id,tb_products.product_name,tb_categories.category_id,tb_measurements.measurement_name,tb_shops.tb_shop_name,tb_stocks.opening_stock FROM tb_products INNER JOIN tb_categories ON tb_categories.category_id=tb_products.category_id INNER JOIN tb_measurements ON tb_measurements.measurement_id=tb_products.measurement_type INNER JOIN tb_shops ON tb_shops.tb_shop_id=tb_categories.shop_id INNER JOIN tb_stocks ON tb_stocks.product_id=tb_products.product_id WHERE tb_shops.tb_shop_id='$shopId'");

			$count=0;

			$response['data']=array();

			
				foreach($results as $row) {
				$data=array();

				$prod_id=$row["product_id"];
				$data["product_id"]=$row["product_id"];
				$data["product_name"]=$row["product_name"];
				$data["category_id"]=$row["category_id"];
				$data["measurement_name"]=$row["measurement_name"];
				$data["tb_shop_name"]=$row["tb_shop_name"];

				$price=$db->GetOne("SELECT selling_price FROM tb_product_prices WHERE 
					product_id=$prod_id ORDER BY price_id DESC limit 1");

				$price_id=$db->GetOne("SELECT price_id FROM tb_product_prices WHERE product_id='$prod_id' and selling_price=$price ORDER BY price_id DESC limit 1");

				$data["price"]=$price;
				$data["price_id"]=$price_id;
				$data["opening_stock"]=$row["opening_stock"];

				array_push($response['data'], $data);
				$count++;

			
			}
			

			$response['success']=1;
			$response['count']=$count;
			$response['message']='items pulled';

			echo json_encode($response);

		
		

}else{
	$response['success']=0;
	$response['message']='missing user id';

	echo json_encode($response);
}

?>