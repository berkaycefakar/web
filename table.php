<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Table</title>
    <!-- CSS stilleri -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Course Table</h1>

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

        // SQL sorgusu - courses ve instructors tablolarını birleştirerek kurs bilgilerini al
        $sql = "SELECT c.id AS course_id, c.name AS course_name, CONCAT(i.name,' ',i.surname) AS instructor_name, c.details
                FROM course c
                INNER JOIN instructor i ON c.insid = i.id";

        $result = $conn->query($sql);

        // Tabloyu oluştur
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th><th>Instructor</th><th>Details</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$row["course_id"]."</td>";
                echo "<td>".$row["course_name"]."</td>";
                echo "<td>".$row["instructor_name"]."</td>";
                echo "<td><a href='details.php?course_id=".$row["course_id"]."'>Details</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "0 results";
        }

        // Veritabanı bağlantısını kapat
        $conn->close();
        ?>

    </div>

</body>
</html>
