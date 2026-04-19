<?php
include "db.php";

$id = $_GET['id'] ?? 0;

// FETCH DATA FROM DB
$result = $conn->query("SELECT * FROM bookings WHERE id = $id");
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Ticket</title>
<style>
body {
  font-family: Arial;
  text-align: center;
  background: #111;
  color: white;
}
.ticket {
  background: #222;
  padding: 20px;
  margin: 50px auto;
  width: 320px;
  border-radius: 10px;
}
</style>
</head>

<body>

<div class="ticket">
  <h2>🎟️ Booking Confirmed</h2>

  <?php if($data) { ?>

    <p><b>Booking ID:</b> <?php echo $data['id']; ?></p>
    <p><b>Name:</b> <?php echo $data['name']; ?></p>
    <p><b>Movie:</b> <?php echo $data['movie']; ?></p>
    <p><b>Seats:</b> <?php echo $data['seats']; ?></p>
    <p><b>Amount:</b> ₹ <?php echo $data['amount']; ?></p>

    <br>
    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php 
    echo urlencode($data['name'].' | '.$data['movie'].' | '.$data['seats'].' | ₹'.$data['amount']); 
    ?>">

  <?php } else { ?>

    <p>❌ Ticket not found</p>

  <?php } ?>

</div>

</body>
</html>