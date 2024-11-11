<?php
include("db_conn.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $imageUrl = '';

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/"; // Ensure this directory exists and is writable
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $imageUrl = $target_file;
    }

    if ($id) {
        // Edit existing project
        $sql = "UPDATE projects SET title=?, description=?, category=?, image_url=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $title, $description, $category, $imageUrl, $id);
    } else {
        // Add new project
        $sql = "INSERT INTO projects (title, description, category, image_url) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $title, $description, $category, $imageUrl);
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
