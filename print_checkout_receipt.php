<?php include 'db_connect.php'; ?>
<?php
// Set the correct timezone (India)
date_default_timezone_set('Asia/Kolkata');

// Fetch data
$qry = $conn->query("SELECT p.*,c.name as cname,c.rate,l.location as lname FROM parked_list p inner join category c on c.id = p.category_id inner join parking_locations l on l.id = p.location_id where p.id= ".$_GET['id']);
foreach($qry->fetch_assoc() as $k => $v){
	$$k = $v;
}

// Get check-in timestamp
$in_qry = $conn->query("SELECT * FROM parking_movement where pl_id = '".$_GET['id']."' and status = 1");
$in_timstamp = $in_qry->num_rows > 0 ? date("Y-m-d H:i", strtotime($in_qry->fetch_array()['created_timestamp'])) : 'N/A';

// Get check-out timestamp if available
$out_qry = $conn->query("SELECT * FROM parking_movement where pl_id = $id and status = 2");
$out_timstamp = $out_qry->num_rows > 0 ? date("M d, Y h:i A", strtotime($out_qry->fetch_array()['created_timestamp'])) : 'N/A';

// Only perform calculation if both timestamps are valid
if ($in_timstamp != 'N/A' && $out_timstamp != 'N/A') {
    // Calculate time difference (in hours)
    $ocalc = abs(strtotime($out_timstamp) - strtotime($in_timstamp));
    $ocalc = ($ocalc / (60 * 60)); // Convert seconds to hours
    $c = explode('.', $ocalc);
    $calc = $c[0];
    
    if (isset($c[1])) {
        $c[1] = floor(60 * ('.'.$c[1]));
        $calc = $c[1] >= 60 ? ($calc + $c[1]) . ':00' : $calc . ':' . $c[1];
    }
} else {
    $calc = 'N/A';
    $ocalc = 0;
}
?>

<style>
	.text-right {
		text-align: right;
	}
	th {
		text-align: left;
	}
</style>

<p><center><b>Parking Receipt</b></center></p>
<table class="table table-bordered" width="100%">
	<tr>
		<th>Parking Ref. No</th>
		<td class="text-right"><?php echo $ref_no ?></td>
	</tr>
	<tr>
		<th>Check-In Timestamp</th>
		<td class="text-right"><?php echo $in_timstamp ?></td>
	</tr>
	<tr>
		<th>Check-Out Timestamp</th>
		<td class="text-right"><?php echo $out_timstamp ?></td>
	</tr>
	<tr>
		<th>Timestamp Difference</th>
		<td class="text-right"><?php echo $calc . " (" . number_format($ocalc, 2) . ")" ?></td>
	</tr>
	<tr>
		<th>Vehicle Type Hourly Rate</th>
		<td class="text-right"><?php echo number_format($rate, 2) ?></td>
	</tr>
	<tr>
		<th>Amount Due</th>
		<td class="text-right"><?php echo number_format($rate * $ocalc, 2) ?></td>
	</tr>
	<tr>
		<th>Amount Tendered</th>
		<td class="text-right"><?php echo number_format($amount_tendered, 2) ?></td>
	</tr>
	<tr>
		<th>Change</th>
		<td class="text-right"><?php echo number_format($amount_change, 2) ?></td>
	</tr>
</table>
