<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Update Student</title>
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
      max-width: 600px;
      width: 100%;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h1{
      text-align: center;
      margin-bottom: 60px;
      color: #333;
    }

    label {
      font-weight: bold;
      display: block;
      margin-top: 15px;
    }

    input[type="text"],
    input[type="email"],
    select,
    input[type="file"] {
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

    .buttons input,
    .buttons button {
      padding: 10px 20px;
      margin: 10px 10px 0 0;
      border: none;
      border-radius: 5px;
      background-color:rgb(139, 124, 239);
      color: white;
      font-size: 16px;
      cursor: pointer;
    }

    .buttons input:hover,
    .buttons button:hover {
      background-color:rgb(60, 180, 49);
    }

    .inline-upload {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 5px;
    width:200px;
    }

    .inline-upload input[type="file"] {
    flex: 1;
    padding: 5px;
    border-color: #333;
    }

    .inline-upload button {
    padding: 10px 15px;
    background-color:rgb(139, 124, 239);
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    }

    .inline-upload button:hover {
    background-color:rgb(60, 180, 49);
    }

  </style>
</head>
<body>
  <div class="container">
    <h1><b>Edit and Update Student Record</b></h1>
    <form action="" method="POST" enctype="multipart/form-data">
      <label for="matric">Matric : </label>
      <input type="text" name="matric" id="matric" required>

      <label for="name">Name : </label>
      <input type="text" name="name" id="name" required>

      <label for="email">Email : </label>
      <input type="email" name="email" id="email" required>

      <label>Race : </label>
      <div class="radio-group" style="display: flex; gap: 10px;">
      <label><input type="radio" name="race" value="Malay" required> Malay</label>
      <label><input type="radio" name="race" value="Chinese"> Chinese</label>
      <label><input type="radio" name="race" value="Indian"> Indian</label>
      </div>


      <label for="gender">Gender : </label>
      <select name="gender" id="gender" required>
        <option value="">-- Select Gender --</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
      </select>

      <label for="fileToUpload">Upload Image : </label>
      <div class="inline-upload">
      <input type="file" name="fileToUpload" id="fileToUpload">
      </div>


      <div class="buttons">
        <input type="submit" name="update" value="UPDATE DATA">
      </div>
    </form>
  </div>
</body>
</html>

<?php
$connection = mysqli_connect("localhost", "root", "", "students");

if (isset($_POST['update'])) {
    $matric = mysqli_real_escape_string($connection, $_POST['matric']);
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $race = mysqli_real_escape_string($connection, $_POST['race']);
    $gender = mysqli_real_escape_string($connection, $_POST['gender']);

    $imageName = '';
    if (!empty($_FILES["fileToUpload"]["name"])) {
        $targetDir = "uploads/";
        $imageName = $matric . "_" . time() . "." . strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION));
        $targetFilePath = $targetDir . $imageName;
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFilePath);
    }

    $query = "UPDATE students SET matric='$matric',name='$name', email='$email', race='$race', gender='$gender'";
    if ($imageName !== '') {
        $query .= ", Image='$imageName'";
    }
    $query .= " WHERE matric='$matric'";

    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        echo "<script>alert('Data Updated Successfully');</script>";
    } else {
        echo "<script>alert('Update Failed');</script>";
    }
}
?>
