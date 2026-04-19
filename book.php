<?php
header("Content-Type: application/json");

// 🔴 SHOW ERRORS (for debugging)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ✅ DB CONNECTION
include "db.php";

// ✅ GET DATA FROM FRONTEND
$data = json_decode(file_get_contents("php://input"), true);

$name   = $data['name'] ?? '';
$email  = $data['email'] ?? '';
$movie  = $data['movie'] ?? '';
$seats  = $data['seats'] ?? '';
$amount = $data['amount'] ?? '';

// ❌ VALIDATION
if (!$name || !$email || !$movie || !$seats || !$amount) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing data"
    ]);
    exit();
}

// ✅ INSERT INTO DATABASE
$sql = "INSERT INTO bookings (name, email, movie, seats, amount)
        VALUES ('$name', '$email', '$movie', '$seats', '$amount')";

if ($conn->query($sql)) {

    $booking_id = $conn->insert_id;

    // ===========================
    // 📧 SEND EMAIL (PHPMailer)
    // ===========================

    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    require 'PHPMailer/src/Exception.php';

    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        // SMTP SETTINGS
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'geethikaboligorla@gmail.com';   // ✅ YOUR GMAIL
        $mail->Password   = 'hyocypqqturbdzzy';               // ✅ YOUR APP PASSWORD
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
           
       $mail->CharSet = 'UTF-8'; 
        // SENDER & RECEIVER
        $mail->setFrom('geethikaboligorla@gmail.com', 'BookMyShow');
        $mail->addAddress($email);

        // EMAIL CONTENT
        $mail->isHTML(true);
        $mail->Subject = '🎟️ Booking Confirmed';

        $mail->Body = "
            <h2>Booking Confirmed 🎉</h2>
            <p><b>Name:</b> $name</p>
            <p><b>Movie:</b> $movie</p>
            <p><b>Seats:</b> $seats</p>
            <p><b>Amount:</b> ₹$amount</p>
            <p><b>Booking ID:</b> $booking_id</p>
        ";

        $mail->send();

    } catch (Exception $e) {
        // Email failed but booking success continues
    }

    // ✅ SUCCESS RESPONSE
    echo json_encode([
        "status" => "success",
        "id" => $booking_id
    ]);

} else {
    echo json_encode([
        "status" => "error",
        "message" => $conn->error   // 🔥 shows DB error
    ]);
}
?>