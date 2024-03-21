<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details</title>
    <!-- CSS stilleri -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        p {
            color: #666;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 10px;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Course Details</h1>

        <?php
        // Veritabanı bağlantı bilgileri
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "web";

        // Veritabanı bağlantısını oluştur
        $conn = new mysqli($servername, $username, $password, $database);

        // Bağlantıyı kontrol et
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Gelen course_id parametresini al
        $course_id = $_GET["course_id"];

        // SQL sorgusu - courses ve instructors tablolarını birleştirerek kurs bilgilerini al
        $course_sql = "SELECT c.id AS course_id, c.name AS course_name, c.details, CONCAT(i.name,' ',i.surname) AS instructor_name
                        FROM course c
                        INNER JOIN instructor i ON c.insid = i.id
                        WHERE c.id = $course_id";

        $course_result = $conn->query($course_sql);

        // Veritabanından gelen kurs bilgilerini ekrana yazdır
        if ($course_result->num_rows > 0) {
            while($course_row = $course_result->fetch_assoc()) {
                echo "<p><strong>Course ID:</strong> " . $course_row["course_id"] . "</p>";
                echo "<p><strong>Course Name:</strong> " . $course_row["course_name"] . "</p>";
                echo "<p><strong>Instructor:</strong> " . $course_row["instructor_name"] . "</p>";
                echo "<p><strong>Details:</strong> " . $course_row["details"] . "</p>";
            }
        } else {
            echo "No course found.";
        }

        // Exam tablosundan verileri al
        $exam_sql = "SELECT * FROM exam WHERE courseid = $course_id";
        $exam_result = $conn->query($exam_sql);

        // Eğer exam varsa, tabloyu oluştur
        if ($exam_result->num_rows > 0) {
            echo "<h2>Exams</h2>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Course ID</th><th>Date</th></tr>";

            // Her bir exam için tabloya bir satır ekle
            while($exam_row = $exam_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $exam_row["id"] . "</td>";
                echo "<td>" . $exam_row["courseid"] . "</td>";
                echo "<td>" . $exam_row["date"] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No exams found for this course.</p>";
        }

        // Veritabanı bağlantısını kapat
        $conn->close();
        ?>
    </div>
</body>
</html>
