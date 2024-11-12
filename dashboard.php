<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Dashboard</h2>
        <?php if ($role == 'patient'): ?>
            <a href="schedule_appointment.php" class="btn btn-primary">Schedule Appointment</a>
        <?php elseif ($role == 'doctor'): ?>
            <a href="medical_status.php" class="btn btn-primary">Record Patient Medical Status</a>
        <?php endif; ?>
        <a href="logout.php" class="btn btn-secondary">Logout</a>
    </div>
</body>
</html>
