<?php
include("db_conn.php");

// Fetch projects from the database
$sql = "SELECT title, description, category, image_url FROM projects";
$result = $conn->query($sql);

// Fetch skills from the database
$sql_skills = "SELECT skills_ FROM skills"; // Assuming skills are stored here
$result_skills = $conn->query($sql_skills);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aleazar John Villanueva | Portfolio</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css"> <!-- Custom styles -->
    <style>
        body {
            background-color: #f3f3e0; /* Your main background color */
        }

        header {
            background-color: #133e87; /* Header color */
            color: white;
            padding: 20px;
            text-align: center;
        }

        .profile-img {
            width: 150px; /* Adjust image size */
            height: 150px;
            border-radius: 50%;
        }

        nav {
            background-color: #608bc1; /* Navigation color */
        }

        nav ul {
            list-style-type: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin: 0 15px;
        }

        nav a {
            color: white;
            text-decoration: none;
        }

        .project-card {
            color: #608bc1;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
            background-color: white;
            transition: transform 0.2s;
        }

        .project-card:hover {
            transform: scale(1.05);
        }

        .skills-list {
            padding: 0;
            list-style-type: none;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #133e87; /* Footer color */
            color: white;
        }

        p{
            font-size: 1.2rem;
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <img src="img/profile.jpg" alt="Profile picture" class="profile-img">
            <h1>Aleazar John Villanueva</h1>
            <p>UI/UX Designer | Web Developer | Programmer</p>
        </div>
    </header>

    <nav class="w3-blue">
        <ul>
            <li><a href="#about">About</a></li>
            <li><a href="#projects">Projects</a></li>
            <li><a href="#skills">Skills</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </nav>

    <section id="about" class="about w3-container">
        <h2>About Me</h2>
        <p>
            My name is <strong>Aleazar John Villanueva</strong>, and I'm a committed web developer with a wide range
            of abilities that span <strong>design</strong> and <strong>development</strong>.
            With my expertise in <strong>Adobe Photoshop</strong> and <strong>Figma</strong>, I produce eye-catching
            designs that enhance <strong>user experience</strong>.
            My technological toolbox consists of <strong>HTML</strong>, <strong>CSS</strong>, and
            <strong>JavaScript</strong> for creating <strong>responsive front-end solutions</strong>,
            while my back-end skills in <strong>PHP</strong>, <strong>C++</strong>, <strong>Java</strong>, and
            <strong>Python</strong> enable me to create reliable applications.
            I'm constantly striving to push the limits of what's feasible in web development because I thrive on
            <strong>innovation</strong> and <strong>lifelong learning</strong>.
            Together, let's make something incredible!
        </p>
    </section>

    <section id="projects" class="projects w3-container">
        <h2>Projects</h2>
        <p>Here are some of the projects I have worked on. Each project reflects my skills and dedication to
            creating impactful solutions.</p>
        <div class="w3-row-padding">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="w3-col m4">';
                    echo '<div class="project-card">';
                    echo '<h3><strong>' . htmlspecialchars($row['category']) . '</strong></h3>';
                    echo '<img src="' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['title']) . '" class="w3-image">';
                    echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
                    echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No projects found.</p>';
            }
            ?>
        </div>
    </section>

    <section id="skills" class="skills w3-container">
        <h2>Skills</h2>
        <p>These are the key skills I possess, enabling me to design and develop high-quality web applications and
            user experiences.</p>
        <ul class="skills-list">
            <?php
            if ($result_skills->num_rows > 0) {
                while ($row = $result_skills->fetch_assoc()) {
                    echo '<li><i class="bi bi-check-circle"></i> ' . htmlspecialchars($row['skills_']) . '</li>';
                }
            } else {
                echo '<li>No skills found.</li>';
            }
            ?>
        </ul>
    </section>

    <section id="contact" class="contact w3-container">
        <h2>Contact</h2>
        <p>If you have any questions, suggestions, or just want to say hi, feel free to reach out! I'm always
            open to discussing new projects, collaborations, or ideas.</p>
        <form>
            <input type="email" placeholder="Your Email" class="w3-input w3-border">
            <input type="text" placeholder="Subject" class="w3-input w3-border">
            <textarea placeholder="Message" class="w3-input w3-border"></textarea>
            <input type="submit" value="Send Message" class="w3-button w3-blue">
        </form>
    </section>

    <footer>
        <p>&copy; 2023 Aleazar John Villanueva. All rights reserved.</p>
    </footer>
</body>

</html>

<?php
$conn->close();
?>
