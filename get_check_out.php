<?php include 'db_connect.php' ?>
<?php
date_default_timezone_set('Asia/Kolkata'); // Set timezone to India

$qry = $conn->query("SELECT p.*,c.name as cname,c.rate,l.location as lname FROM parked_list p inner join category c on c.id = p.category_id inner join parking_locations l on l.id = p.location_id where p.id= ".$_GET['id']);
foreach($qry->fetch_assoc() as $k => $v){
	$$k = $v;
}
$in_qry = $conn->query("SELECT * FROM parking_movement where pl_id = '".$_GET['id']."' and status = 1");
$in_timstamp = $in_qry->num_rows > 0 ? date("Y-m-d H:i",strtotime($in_qry->fetch_array()['created_timestamp'])) : 'N/A';
$now = date('Y-m-d H:i');

// Calculate the number of hours parked
$ocalc = abs(strtotime($now)-strtotime($in_timstamp));
$ocalc = ($ocalc / (60*60)); // convert seconds to hours
$c = explode('.', $ocalc);
$calc = $c[0];
if(isset($c[1])){
    $c[1] = floor(60 * ('.'.$c[1]));
    $calc = $c[1] >= 60 ? ($calc + $c[1]).':00' : $calc.':'.$c[1]; 
}

// Apply parking charge logic
if ($ocalc <= 1) {
    $amount_due = $rate;  // Charge the regular rate for the first hour
} else {
    $additional_hours = ceil($ocalc - 1);  // Calculate additional hours
    $amount_due = $rate + (100 * $additional_hours);  // Charge 100 rupees for each additional hour
}
?>

<form action="" id="checkout_frm">
	<div class="col-md-12 mt-2">
		<table class="table table-bordered">
			<tr>
				<th>Check-In Timestamp</th>
				<td class="text-right"><?php echo $in_timstamp ?></td>
			</tr>
			<tr>
				<th>Check-Out Timestamp</th>
				<td class="text-right"><?php echo $now ?></td>
			</tr>
			<tr>
				<th>Timestamp Difference</th>
				<td class="text-right"><?php echo $calc ." (".(number_format($ocalc,2)).")" ?></td>
			</tr>
			<tr>
				<th>Vehicle Type Hourly Rate</th>
				<td class="text-right"><?php echo number_format($rate,2) ?></td>
			</tr>
			<tr>
				<th>Amount Due</th>
				<td class="text-right"><?php echo number_format($amount_due, 2) ?></td>
			</tr>
			<tr>
				<th>Amount Tendered</th>
				<td class="text-right">
					<input type="hidden" name="pl_id" value="<?php echo $id ?>" class="form-control">
					<input type="hidden" name="created_timestamp" value="<?php echo $now ?>" class="form-control">
					<input type="hidden" name="amount_due" value="<?php echo $amount_due ?>" class="form-control">
					<input type="number" name="amount_tendered" step="any" class="form-control text-right">
				</td>
			</tr>
			<tr>
				<th>Change</th>
				<td class="text-right">
					<input type="number" name="amount_change" readonly="" step="any" class="form-control text-right">
				</td>
			</tr>
		</table>
		<div class="col-md-12">
			<button class="btn-sm col-md-3 float-right btn-primary btn-block"><i class="fa fa-arrow-alt-circle-right"></i> Checkout</button>
		</div>
	</div>
</form>

<script>
	$('[name="amount_tendered"]').on('keyup keydown keypress change',function(){
		var tendered = $(this).val()
		var amount = $('[name="amount_due"]').val()
		change = parseFloat(tendered) - parseFloat(amount) 

		$('[name="amount_change"]').val(change.toFixed(2))
	})
	$('#checkout_frm').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=checkout_vehicle',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp == 1){
					alert_toast("Success","success")
					var nw = window.open("print_checkout_receipt.php?id=<?php echo $_GET['id'] ?>","_blank","height=500,width=800")
					nw.print()
					setTimeout(function(){
						nw.close()
						location.reload()
					},500)
				}
			}
		})
	})
</script>
