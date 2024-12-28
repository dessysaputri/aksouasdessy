<?php
$servername = "mysql"; // Hostname sesuai dengan nama service di docker-compose
$username = "wardahdessy"; // Username database
$password = "wardahdessy"; // Password database
$dbname = "dancer"; // Nama database

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Memproses data jika method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi data input
    $name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : '';
    $phone = isset($_POST['phone']) ? $conn->real_escape_string($_POST['phone']) : '';
    $university = isset($_POST['university']) ? $conn->real_escape_string($_POST['university']) : '';

    if (!empty($name) && !empty($phone) && !empty($university)) {
        // Menggunakan prepared statements untuk keamanan
        $stmt = $conn->prepare("INSERT INTO users (name, phone, university) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $phone, $university);

        if ($stmt->execute()) {
            echo "Data saved successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "All fields are required!";
    }
}

// Menutup koneksi
$conn->close();
?>
