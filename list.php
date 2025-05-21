<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Search Students Data</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      padding: 40px;
      display: flex;
      justify-content: center;
    }

    .container {
      background-color:rgb(244, 172, 219);
      border-radius: 10px;
      padding: 30px;
      max-width: 800px;
      width: 100%;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h1 {
      text-align: center;
      margin-bottom: 25px;
      color: #333;
    }

    label {
      font-weight: bold;
      display: block;
      margin-top: 15px;
    }

    input[type="text"],
    select {
      width: 70%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .radio-group {
      margin-top: 5px;
    }

    .radio-group label {
      font-weight: normal;
      margin-right: 15px;
    }

    .buttons {
      margin-top: 25px;
      text-align: center;
    }

    .buttons input {
      padding: 10px 20px;
      margin: 10px 10px 0 0;
      border: none;
      border-radius: 5px;
      background-color:rgb(139, 124, 239);
      color: white;
      font-size: 16px;
      cursor: pointer;
    }

    .buttons input:hover {
      background-color:rgb(60, 180, 49);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    table, th, td {
      border: 1px solid #ddd;
    }

    th, td {
      padding: 20px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .search-section {
      margin-bottom: 20px;
      padding: 15px;
      background-color: #f8f8f8;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1><b>Student Records</b></h1>
    
    <div class="search-section">
      <form action="" method="GET">
        <label>Search by Race:</label>
        <div class="radio-group">
          <label><input type="radio" name="search_type" value="race" checked> Race</label>
          <label><input type="radio" name="search_type" value="gender"> Gender</label>
        </div>

        <div id="race_search">
          <label>Select Race:</label>
          <select name="race">
            <option value="">-- All Races --</option>
            <option value="Malay">Malay</option>
            <option value="Chinese">Chinese</option>
            <option value="Indian">Indian</option>
          </select>
        </div>

        <div id="gender_search" style="display:none;">
          <label>Select Gender:</label>
          <select name="gender">
            <option value="">-- All Genders --</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>

        <div class="buttons">
          <input type="submit" name="search" value="SEARCH">
          <input type="button" value="RESET" onclick="window.location.href='list.php'">
        </div>
      </form>
    </div>

    <?php
    $connection = mysqli_connect("localhost", "root", "", "students");
    
    if (isset($_GET['search'])) {
        $search_type = $_GET['search_type'];
        $where = "";
        
        if ($search_type == 'race' && !empty($_GET['race'])) {
            $race = mysqli_real_escape_string($connection, $_GET['race']);
            $where = "WHERE race = '$race'";
        } elseif ($search_type == 'gender' && !empty($_GET['gender'])) {
            $gender = mysqli_real_escape_string($connection, $_GET['gender']);
            $where = "WHERE gender = '$gender'";
        }
        
        $query = "SELECT * FROM students $where ORDER BY name";
        $result = mysqli_query($connection, $query);
        
        if (mysqli_num_rows($result) > 0) {
            echo "<h3>Search Results</h3>";
            echo "<table>";
            echo "<tr><th>Matric</th><th>Name</th><th>Email</th><th>Race</th><th>Gender</th><th>Image</th></tr>";
            
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row['Matric']."</td>";
                echo "<td>".$row['Name']."</td>";
                echo "<td>".$row['Email']."</td>";
                echo "<td>".$row['Race']."</td>";
                echo "<td>".$row['Gender']."</td>";
                echo "<td>";
                if (!empty($row['Image'])) {
                    echo "<img src='uploads/".$row['Image']."' width='50'>";
                } else {
                    echo "No image";
                }
                echo "</td>";
                echo "</tr>";
            }
            
            echo "</table>";
        } else {
            echo "<p>No students found matching your criteria.</p>";
        }
    } else {

        $query = "SELECT * FROM students ORDER BY name";
        $result = mysqli_query($connection, $query);
        
        if (mysqli_num_rows($result) > 0) {
            echo "<h3>All Students</h3>";
            echo "<table>";
            echo "<tr><th>Matric</th><th>Name</th><th>Email</th><th>Race</th><th>Gender</th><th>Image</th></tr>";
            
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row['matric']."</td>";
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['email']."</td>";
                echo "<td>".$row['race']."</td>";
                echo "<td>".$row['gender']."</td>";
                echo "<td>";
                if (!empty($row['Image'])) {
                    echo "<img src='uploads/".$row['Image']."' width='50'>";
                } else {
                    echo "No image";
                }
                echo "</td>";
                echo "</tr>";
            }
            
            echo "</table>";
        } else {
            echo "<p>No students found in the database.</p>";
        }
    }
    ?>
  </div>

  <script>

    document.querySelectorAll('input[name="search_type"]').forEach(radio => {
      radio.addEventListener('change', function() {
        if (this.value === 'race') {
          document.getElementById('race_search').style.display = 'block';
          document.getElementById('gender_search').style.display = 'none';
        } else {
          document.getElementById('race_search').style.display = 'none';
          document.getElementById('gender_search').style.display = 'block';
        }
      });
    });
  </script>
</body>
</html>