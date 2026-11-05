<?php
include('../includes/pdoconfig.php');

// Room seater and booking check
if (!empty($_POST["roomid"])) {
    $id = $_POST['roomid'];

    // Get seater capacity
    $stmt = $DB_con->prepare("SELECT seater FROM rooms WHERE room_no = :id");
    $stmt->execute([':id' => $id]);
    $room = $stmt->fetch(PDO::FETCH_ASSOC);
    $seater = (int)$room['seater'];

    // Get current bookings
    $stmt2 = $DB_con->prepare("SELECT COUNT(*) FROM registration WHERE roomno = :id");
    $stmt2->execute([':id' => $id]);
    $booked = (int)$stmt2->fetchColumn();

    if ($booked >= $seater) {
        echo json_encode([
            'status' => 'full',
            'message' => 'Room is already full!',
            'redirect' => 'dashboard.php' // change to your dashboard filename
        ]);
        exit;
    } else {
        echo json_encode([
            'status' => 'ok',
            'seater' => $seater
        ]);
        exit;
    }
}

// Room fees
if (!empty($_POST["rid"])) {
    $id = $_POST['rid'];
    $stmt = $DB_con->prepare("SELECT fees FROM rooms WHERE room_no = :id");
    $stmt->execute([':id' => $id]);
    $room = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $room['fees'];
}
?>
