<?php
session_start();
include('connect.php');

if ($_SESSION['role'] != 'patient') {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM appointments WHERE patient_id = (SELECT id FROM users WHERE username = '$_SESSION[username]')";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Appointments</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Your Appointments</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Doctor</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['appointment_date']; ?></td>
                    <td><?php echo $row['doctor_name']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="schedule_appointment.php" class="btn btn-primary">Schedule New Appointment</a>
    </div>
</body>
</html>
