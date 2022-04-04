<?php
//Connecting to database
$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";
//Create a connection
$conn = mysqli_connect($servername, $username, $password, $database);
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = "INSERT INTO `auth` (`username`, `password`) VALUES ('$username', '$password')";
    $result = mysqli_query($conn, $query);
    if($result){
        $insert = true;
        header('location:login.php');
    }
    else
        echo "Signup failed";
}
?>
<!DOCTYPE html>
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.js"
        integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Signup</title>
</head>
<body>
    <h1 style="text-align: center;">Signup form</h1>
    <div class="col-md-4 offset-md-4">
        <form method="POST">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Username</label>
                <input type="name" class="form-control" name="username" id="exampleInputEmail1"
                    aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1" required>
            </div>
            <button type="submit" class="btn btn-primary">SignUp</button>
        </form>
        <p>Already an user??
            <a href="login.php">Login</a>
        </p>
    </div>
</body>
</html>