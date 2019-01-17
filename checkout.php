<?php 
@require_once('db_connection.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Payment Checkout</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
		<br />
		<div class="container">
			<br />
			<div class="content"><center>
                <img src="kf.png" height="150px" style="padding-bottom: 10px"><br>
                 <font style="font-family: 'Open Sans', sans-serif;font-size: 22px;color: #292929;">KIIT FEST 5.0</font><br><br>
                 <h3 align="center"> Kiit-Fest  <a href="https:kiitfest.org" title="Event Selection">Event Selection</a></h3>
                </center>
            </div>
			<?php
				$query = "SELECT * FROM event_details ORDER BY id ASC";
				$result = mysqli_query($connect, $query);
				if(mysqli_num_rows($result) > 0)
				{
					while($row = mysqli_fetch_array($result))
					{
				?>
			<div class="col-md-4">
				<form method="post" action="index.php?action=add&id=<?php echo $row["id"]; ?>">
					<div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:6px;" align="center">
						<h4><?php echo $row["event_name"]; ?></h4>
						<h4>$ <?php echo $row["date"]; ?></h4>
						<h4>$ <?php echo $row["time"]; ?></h4>
						<h4>$ <?php echo $row["venue"]; ?></h4>
					</div>
				</form>
			</div>
			<?php
					}
				}
			?>
			
			<br />
			<h3>Selected Events</h3>
			<div class="row">
			<div class="table-responsive">
				<table class="table table-bordered">
					<tr>
						<th width="40%"><center> <strong> Event Name </strong></center></th>
						<th width="10%"><center> <strong> Date </strong></center></th>
						<th width="20%"><center> <strong> Time </strong></center></th>
						<th width="20%"><center> <strong> Venue </strong></center></th>
						
					</tr>
					<tr>
						<td><?php echo $values["event_name"]; ?></td>
						<td><?php echo $values["date"]; ?></td>
						<td>$ <?php echo $values["time"]; ?></td>
						<td>$ <?php echo number_format($values["venue"] * $values["item_price"], 2);?></td>
					</tr>				
				</table>
			</div>
		</div>
		<br>
		<div clas="row">
			<center> <input style="outline:none;" type="image" src="images/button_secure-checkout.png"></center>
		</div>
		</div>
	</div>
	<br />
	</body>
</html>
<?php
/*function array_column($array, $column_name)
{
	$output = array();
	foreach($array as $keys => $values)
	{
		$output[] = $values[$column_name];
	}
	return $output;
}*/
?>