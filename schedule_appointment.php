<?php
include 'database.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = $_SESSION['user_id'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];

    $stmt = $pdo->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date) VALUES (?, ?, ?)");
    $stmt->execute([$patient_id, $doctor_id, $appointment_date]);

    echo "Appointment scheduled successfully!";
}

$doctors = $pdo->query("SELECT id, username FROM users WHERE role = 'doctor'")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Schedule Appointment</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Schedule Appointment</h2>
        <form method="POST">
            <div class="form-group">
                <label for="doctor">Choose Doctor</label>
                <select name="doctor_id" class="form-control" required>
                    <?php foreach ($doctors as $doctor): ?>
                        <option value="<?= $doctor['id']; ?>"><?= $doctor['username']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="appointment_date">Appointment Date</label>
                <input type="datetime-local" name="appointment_date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Schedule</button>
        </form>
    </div>
</body>
</html>
