<?php
// ================= DATABASE CONFIG =================
$host = "YOUR_RDS_ENDPOINT";
$username = "YOUR_DB_USERNAME";
$password = "YOUR_DB_PASSWORD";
$database = "YOUR_DATABASE_NAME";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// ================= FORM SUBMISSION =================
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name   = $_POST['name'];
    $place  = $_POST['place'];
    $phone  = $_POST['phone'];
    $email  = $_POST['email'];
    $course = $_POST['course'];

    $sql = "INSERT INTO student_registration (name, place, phone, email, course)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $place, $phone, $email, $course);

    if ($stmt->execute()) {
        $success = "🎉 Registration Successful!";
    } else {
        $error = "❌ Something went wrong. Please try again.";
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Registration | SMS College</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body {
  margin: 0;
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #0072ff, #00c6ff);
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}

.card {
  background: #fff;
  width: 420px;
  padding: 30px;
  border-radius: 15px;
  box-shadow: 0 15px 40px rgba(0,0,0,0.2);
  animation: fadeUp 1s ease;
}

.card h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #0a1a2f;
}

.form-group {
  margin-bottom: 15px;
}

label {
  font-weight: 600;
  display: block;
  margin-bottom: 5px;
}

input, select {
  width: 100%;
  padding: 10px;
  border-radius: 8px;
  border: 1px solid #ccc;
}

.btn {
  width: 100%;
  padding: 12px;
  background: #0072ff;
  border: none;
  color: #fff;
  font-size: 16px;
  font-weight: 600;
  border-radius: 25px;
  cursor: pointer;
  margin-top: 10px;
}

.btn:hover {
  background: #005ad1;
}

.success {
  color: green;
  text-align: center;
  margin-bottom: 10px;
  font-weight: 600;
}

.error {
  color: red;
  text-align: center;
  margin-bottom: 10px;
  font-weight: 600;
}

@keyframes fadeUp {
  from {
    opacity: 0;
    transform: translateY(40px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
</head>

<body>

<div class="card">
  <h2>Student Registration</h2>

  <?php if ($success) echo "<div class='success'>$success</div>"; ?>
  <?php if ($error) echo "<div class='error'>$error</div>"; ?>

  <form method="POST">

    <div class="form-group">
      <label>Full Name</label>
      <input type="text" name="name" required>
    </div>

    <div class="form-group">
      <label>Place / City</label>
      <input type="text" name="place" required>
    </div>

    <div class="form-group">
      <label>Phone Number</label>
      <input type="text" name="phone" required>
    </div>

    <div class="form-group">
      <label>Email Address</label>
      <input type="email" name="email" required>
    </div>

    <div class="form-group">
      <label>Course</label>
      <select name="course" required>
        <option value="">Select Course</option>
        <option>Computer Engineering</option>
        <option>Electronics & Telecommunication</option>
        <option>Mechanical Engineering</option>
        <option>Civil Engineering</option>
      </select>
    </div>

    <button type="submit" class="btn">Register</button>

  </form>
</div>

</body>
</html>