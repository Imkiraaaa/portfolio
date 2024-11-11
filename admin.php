<?php
include("db_conn.php");

// Fetch projects from the database
$sql_projects = "SELECT id, title, description, category, image_url FROM projects";
$result_projects = $conn->query($sql_projects);

// Fetch skills from the database
$sql_skills = "SELECT id, skills_, experience FROM skills"; // Updated field names
$result_skills = $conn->query($sql_skills);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Portfolio Management</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-colors-flat.css">
    <style>
        .modal {
            display: none;
        }
    </style>
</head>

<body class="w3-flat-silver">

<!-- Header Section -->
<header class="w3-container w3-flat-midnight-blue w3-center w3-padding-32">
    <h1>Admin Dashboard</h1>
    <p>Manage Projects and Skills</p>
</header>

<!-- Projects Section -->
<section id="projects" class="w3-container w3-padding">
    <h2>Projects</h2>
    <button onclick="openModal('projectModal')" class="w3-button w3-flat-belize-hole w3-margin-bottom">Add New Project</button>
    
    <!-- Search Bar -->
    <input class="w3-input w3-margin-bottom w3-border" type="text" id="searchProject" onkeyup="searchTable('projectTable', 'searchProject')" placeholder="Search for projects...">

    <div class="w3-responsive">
        <table class="w3-table-all" id="projectTable">
            <tr class="w3-flat-clouds">
                <th>Title</th>
                <th>Description</th>
                <th>Category</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php
            if ($result_projects && $result_projects->num_rows > 0) {
                while ($row = $result_projects->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['title']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['description']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['category']) . '</td>';
                    echo '<td><img src="' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['title']) . '" width="50"></td>';
                    echo '<td>
                            <button onclick="editProject(' . $row['id'] . ', \'' . addslashes($row['title']) . '\', \'' . addslashes($row['description']) . '\', \'' . addslashes($row['category']) . '\', \'' . addslashes($row['image_url']) . '\')" class="w3-button w3-small w3-green">Edit</button>
                            <button onclick="deleteProject(' . $row['id'] . ')" class="w3-button w3-small w3-red">Delete</button>
                          </td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="5">No projects found.</td></tr>';
            }
            ?>
        </table>
    </div>
</section>

<!-- Skills Section -->
<section id="skills" class="w3-container w3-padding">
    <h2>Skills</h2>
    <button onclick="openModal('skillModal')" class="w3-button w3-flat-belize-hole w3-margin-bottom">Add New Skill</button>
    
    <!-- Search Bar -->
    <input class="w3-input w3-margin-bottom w3-border" type="text" id="searchSkill" onkeyup="searchTable('skillTable', 'searchSkill')" placeholder="Search for skills...">

    <div class="w3-responsive">
        <table class="w3-table-all" id="skillTable">
            <tr class="w3-flat-clouds">
                <th>Skill</th>
                <th>Experience</th> <!-- Added Experience Column -->
                <th>Actions</th>
            </tr>
            <?php
            if ($result_skills && $result_skills->num_rows > 0) {
                while ($row = $result_skills->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['skills_']) . '</td>'; // Updated field name
                    echo '<td>' . htmlspecialchars($row['experience']) . '</td>'; // Added Experience data
                    echo '<td>
                            <button onclick="editSkill(' . $row['id'] . ', \'' . addslashes($row['skills_']) . '\', \'' . addslashes($row['experience']) . '\')" class="w3-button w3-small w3-green">Edit</button>
                            <button onclick="deleteSkill(' . $row['id'] . ')" class="w3-button w3-small w3-red">Delete</button>
                          </td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="3">No skills found.</td></tr>'; // Updated column span
            }
            ?>
        </table>
    </div>
</section>

<!-- Project Modal -->
<div id="projectModal" class="w3-modal modal">
    <div class="w3-modal-content w3-padding">
        <span onclick="closeModal('projectModal')" class="w3-button w3-display-topright">&times;</span>
        <h3>Add/Edit Project</h3>
        <form method="POST" action="add_edit_project.php" enctype="multipart/form-data">
            <label>Title</label>
            <input type="text" name="title" id="projectTitle" class="w3-input w3-border" required>
            <label>Description</label>
            <textarea name="description" id="projectDescription" class="w3-input w3-border" rows="4" required></textarea>
            <label>Category</label>
            <input type="text" name="category" id="projectCategory" class="w3-input w3-border">
            <label>Image</label>
            <input type="file" name="image" class="w3-input w3-border">
            <input type="hidden" name="id" id="projectId">
            <button type="submit" class="w3-button w3-green w3-margin-top">Save</button>
        </form>
    </div>
</div>

<!-- Skill Modal -->
<div id="skillModal" class="w3-modal modal">
    <div class="w3-modal-content w3-padding">
        <span onclick="closeModal('skillModal')" class="w3-button w3-display-topright">&times;</span>
        <h3>Add/Edit Skill</h3>
        <form method="POST" action="add_edit_skill.php">
            <label>Skill</label>
            <input type="text" name="skills" id="skillName" class="w3-input w3-border" required> <!-- Updated field name -->
            <label>Experience</label>
            <textarea name="experience" id="skillExperience" class="w3-input w3-border" rows="4" required></textarea> <!-- Added Experience field -->
            <input type="hidden" name="id" id="skillId">
            <button type="submit" class="w3-button w3-green w3-margin-top">Save</button>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).style.display = 'block';
    }

    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    function editProject(id, title, description, category, imageUrl) {
        document.getElementById('projectId').value = id;
        document.getElementById('projectTitle').value = title;
        document.getElementById('projectDescription').value = description;
        document.getElementById('projectCategory').value = category;
        openModal('projectModal');
    }

    function deleteProject(id) {
        if (confirm("Are you sure you want to delete this project?")) {
            window.location.href = `delete_project.php?id=${id}`;
        }
    }

    function editSkill(id, skillName, experience) {
        document.getElementById('skillId').value = id;
        document.getElementById('skillName').value = skillName;
        document.getElementById('skillExperience').value = experience; // Set experience
        openModal('skillModal');
    }

    function deleteSkill(id) {
        if (confirm("Are you sure you want to delete this skill?")) {
            window.location.href = `delete_skill.php?id=${id}`;
        }
    }

    function searchTable(tableId, inputId) {
        const filter = document.getElementById(inputId).value.toUpperCase();
        const rows = document.getElementById(tableId).getElementsByTagName("tr");
        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName("td");
            let match = false;
            for (let j = 0; j < cells.length; j++) {
                if (cells[j].textContent.toUpperCase().includes(filter)) {
                    match = true;
                    break;
                }
            }
            rows[i].style.display = match ? "" : "none"; // Show or hide the row based on match
        }
    }
</script>

</body>
</html>
