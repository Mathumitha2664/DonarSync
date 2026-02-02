<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Find a Donor</title>
  <style>
    body {
      margin: 0;
      padding: 20px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: url('blood-donation.jpg') no-repeat center center/cover;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      color: white;
    }

    .container {
      background: rgba(0, 0, 0, 0.75);
      padding: 30px 40px;
      border-radius: 12px;
      max-width: 600px;
      width: 90%;
      box-shadow: 0 0 20px rgba(0,0,0,0.9);
    }

    h2 {
      text-align: center;
      margin-bottom: 25px;
      font-weight: 700;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    label {
      font-weight: 600;
      margin-bottom: 6px;
      display: block;
    }

    input[type="text"],
    select {
      width: 100%;
      padding: 10px 14px;
      border-radius: 8px;
      border: none;
      font-size: 1rem;
    }

    input[type="text"]:focus,
    select:focus {
      outline: 2px solid #d9534f;
      background-color: #fff;
      color: #000;
    }

    button[type="submit"] {
      padding: 14px;
      background-color: #d9534f;
      border: none;
      border-radius: 10px;
      color: white;
      font-size: 1.1rem;
      font-weight: 700;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
      background-color: #c9302c;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 25px;
      color: white;
      box-shadow: 0 0 10px rgba(0,0,0,0.7);
    }

    th, td {
      padding: 12px 15px;
      border: 1px solid #d9534f;
      text-align: left;
      font-weight: 600;
      background: rgba(217, 83, 79, 0.15);
    }

    th {
      background: #d9534f;
      color: white;
    }

    .no-results {
      margin-top: 20px;
      font-size: 1.1rem;
      font-weight: 600;
      color: #f0ad4e;
      text-align: center;
    }

    .back-btn {
      margin-top: 30px;
      background-color: #5bc0de;
      border: none;
      border-radius: 10px;
      width: 100%;
      padding: 14px;
      color: white;
      font-weight: 700;
      font-size: 1.1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .back-btn:hover {
      background-color: #31b0d5;
    }

    @media (max-width: 480px) {
      .container {
        padding: 20px;
      }

      input[type="text"],
      select,
      button {
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Search for a Blood Donor</h2>
    <form method="GET" action="">
      <label for="blood_group">Blood Group</label>
      <select id="blood_group" name="blood_group">
        <option value="">Any</option>
        <option value="A+">A+</option>
        <option value="A-">A-</option>
        <option value="B+">B+</option>
        <option value="B-">B-</option>
        <option value="O+">O+</option>
        <option value="O-">O-</option>
        <option value="AB+">AB+</option>
        <option value="AB-">AB-</option>
      </select>

      <label for="location">Location</label>
      <input type="text" name="location" id="location" placeholder="Enter city or area" />

      <label for="full_name">Full Name (optional)</label>
      <input type="text" name="full_name" id="full_name" placeholder="Enter full name" />

      <button type="submit">Search</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && (isset($_GET['blood_group']) || isset($_GET['location']) || isset($_GET['full_name']))) {
        $host = "localhost";
        $port = 3307;
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "tamilhacks";

        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname, $port);

        if ($conn->connect_error) {
            die("<p class='no-results'>Connection failed: " . htmlspecialchars($conn->connect_error) . "</p>");
        }

        // Sanitize inputs for security
        $blood_group = $conn->real_escape_string($_GET['blood_group'] ?? '');
        $location = $conn->real_escape_string($_GET['location'] ?? '');
        $full_name = $conn->real_escape_string($_GET['full_name'] ?? '');

        $sql = "SELECT full_name, phone_number, location, blood_group FROM donors WHERE 1=1";
        if (!empty($blood_group)) $sql .= " AND blood_group = '$blood_group'";
        if (!empty($location)) $sql .= " AND location LIKE '%$location%'";
        if (!empty($full_name)) $sql .= " AND full_name LIKE '%$full_name%'";

        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            echo "<h3>Results:</h3>";
            echo "<table><tr><th>Name</th><th>Phone</th><th>Location</th><th>Blood Group</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr><td>" . htmlspecialchars($row['full_name']) . "</td><td>" . htmlspecialchars($row['phone_number']) . "</td><td>" . htmlspecialchars($row['location']) . "</td><td>" . htmlspecialchars($row['blood_group']) . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p class='no-results'>No donors found matching the criteria.</p>";
        }

        $conn->close();
    }
    ?>

    <button class="back-btn" onclick="location.href='home.html'">Back to Home</button>
  </div>
</body>
</html>
