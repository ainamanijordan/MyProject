<?php
include 'database.php';
session_start();

// Ensure that the user is logged in as a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header("Location: login.php");
    exit;
}

// If the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctor_id = $_SESSION['user_id'];
    $patient_id = $_POST['patient_id'];
    $description = $_POST['description'];
    
    // Insert the medical record into the database
    try {
        $stmt = $pdo->prepare("INSERT INTO medical_status (patient_id, doctor_id, description) VALUES (?, ?, ?)");
        $stmt->execute([$patient_id, $doctor_id, $description]);
        $message = "Medical record saved successfully!";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}

// Fetch all patients from the database for the doctor to choose from
$patients = $pdo->query("SELECT id, username FROM users WHERE role = 'patient'")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Medical Status</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Record Medical Status</h2>
        
        <?php if (isset($message)) { echo "<div class='alert alert-info'>$message</div>"; } ?>
        
        <form method="POST">
            <!-- Patient Selection -->
            <div class="form-group">
                <label for="patient_id">Select Patient</label>
                <select name="patient_id" class="form-control" required>
                    <option value="">-- Choose a Patient --</option>
                    <?php foreach ($patients as $patient): ?>
                        <option value="<?= $patient['id']; ?>"><?= $patient['username']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Medical Status Description -->
            <div class="form-group">
                <label for="description">Medical Status</label>
                <textarea name="description" class="form-control" rows="5" required></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Save Medical Record</button>
        </form>
    </div>
</body>
</html>
