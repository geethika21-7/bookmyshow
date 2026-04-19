<?php
include "db.php";

$result = $conn->query("SELECT * FROM bookings ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>My Bookings</title>
<style>
body {
  font-family: Arial;
  background: #111;
  color: white;
  text-align: center;
}

.card {
  background: #222;
  margin: 20px auto;
  padding: 20px;
  width: 300px;
  border-radius: 10px;
}
</style>
</head>

<body>

<h2>🎟️ My Bookings</h2>

<?php while($row = $result->fetch_assoc()) { ?>

<div class="card">
  <p><b>ID:</b> <?php echo $row['id']; ?></p>
  <p><b>Name:</b> <?php echo $row['name']; ?></p>
  <p><b>Movie:</b> <?php echo $row['movie']; ?></p>
  <p><b>Seats:</b> <?php echo $row['seats']; ?></p>
  <p><b>Amount:</b> ₹<?php echo $row['amount']; ?></p>

  <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=<?php 
  echo urlencode($row['name'].'-'.$row['movie'].'-'.$row['seats']); 
  ?>">
</div>

<?php } ?>

</body>
</html>