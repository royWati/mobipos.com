<?php

include('controllers/db.php');

global $db;

$response;
if(isset($_REQUEST['name'])
&&isset($_REQUEST['mac_address'])
&&isset($_REQUEST['branch_id'])){

	$name=$_REQUEST['name'];
  $mac=$_REQUEST['mac_address'];
  $branch_id=$_REQUEST['branch_id'];

	$data=array();

	$data['tb_printer_name']=$name;
	$data['client_id']=$user_id;
  $data['tb_printer_mac']=$mac;
  $data['tb_branch']=$user_id;
	$data['active_status']='1';

	$db->AutoExecute('tb_printers',$data, 'INSERT');

	$response['success']=1;
	$response['message']="Printer Added Successfully";

		echo json_encode($response);

}else{
	$response['success']=0;
	$response['message']="Some information required";

		echo json_encode($response);
}
?>
