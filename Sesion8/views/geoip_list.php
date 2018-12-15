<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Entregable 8</title>
	<base href="http://<?= $_SERVER['SERVER_NAME'] ?><?= dirname($_SERVER['PHP_SELF']) ?>/" />
</head>
<body>

<?php    
if(isset($_POST['submitButton'])){ 
  $ipaddress = $_POST['ipAddress'];
  $ip_controller = new IP_controller();
  $network = $ip_controller->getNetwork($ipaddress);
  $controller = new GeoIP();
  $result = $controller->getList($network);
}    
?>   
    
<form method="post">
<input name="ipAddress" placeholder="IP" type="text" >
<input name="netmask" placeholder="255.255.255.0" type="text" disabled>
<input name="submitButton" type="submit">
</form>
<table>
	<tr>
         <th>Net</th>
         <th>Codigo Postal</th>
	 <th>Latitud</th>
	 <th>Longitud</th>
	 <th>Ciudad</th>
	 <th>Pais</th>
	</tr>
        <?php foreach ($result as $geoip): ?>
		<tr>
                   <td><?php echo $geoip['network'] ?></td>
		   <td><?php echo $geoip['postal_code'] ?></td>
		   <td><?php echo $geoip['latitude'] ?></td>
		   <td><?php echo $geoip['longitude'] ?></td>
		   <td><?php echo $geoip['city_name'] ?></td>
                   <td><?php echo $geoip['country_name'] ?></td>
		</tr>
	<?php endforeach ?>
</table>
</body>
</html>
