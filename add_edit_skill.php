<?php
include("db_conn.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
    $skill = $_POST['skills']; // Changed to match the new field name
    $experience = $_POST['experience']; // Added for experience

    if ($id) {
        // Edit existing skill
        $sql = "UPDATE skills SET skills_=?, experience=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("ssi", $skill, $experience, $id); // Added experience
    } else {
        // Add new skill
        $sql = "INSERT INTO skills (skills_, experience) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("ss", $skill, $experience); // Added experience
    }

    if ($stmt->execute()) {
        header("Location: admin.php"); // Redirect back to admin dashboard
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
