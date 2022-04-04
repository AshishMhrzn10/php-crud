<?php 
    session_start();
    if(!$_SESSION['auth']){
        header('location:login.php');
    }
    $insert = false;  //ALerting component
    $update = false;  //ALerting component
    $delete = false;  //ALerting component
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "notes";
    $conn = mysqli_connect($servername, $username, $password, $database);
    if(!$conn){
        die("Sorry, we failed to connect: ". mysqli_connect_error());
    }
    if(isset($_GET['delete'])){
        $sno = $_GET['delete'];
        $delete = true;
        $sql = "DELETE from `notes` WHERE `notes`.`sno` = '$sno'";
        $result = mysqli_query($conn, $sql);
    }
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST['snoEdit'])){
            //Update record
            $title = $_POST["titleEdit"];
            $description = $_POST["descriptionEdit"];
            $edit = $_POST["snoEdit"];
            //SQL Query to be executed
            $sql = "UPDATE `notes` SET `title`= '$title',`description`= '$description' WHERE `notes`.`sno` = '$edit'";
            $result = mysqli_query($conn, $sql);
            if($result)
                $update = true;
            else
                echo "The record was not inserted due to this error ---> ". mysqli_error($conn);
        }

        else if(isset($_POST['delete'])){
            $sno = $_POST['delete'];
            $delete = true;
            $sql = "DELETE from `notes` WHERE `notes`.`sno` = '$sno'";
            $result = mysqli_query($conn, $sql);
            if($result)
                $delete = true;
            else
                echo "The record was not inserted due to this error ---> ". mysqli_error($conn);
        }

        else{
            $title = $_POST["title"];
            $description = $_POST["description"];
            $user = $_SESSION["username"];
            $sql = "INSERT INTO `notes` (`title`, `description`, `user`) VALUES ('$title', '$description', '$user')";
            $result = mysqli_query($conn, $sql);
            if($result)
                $insert = true;
            else
                echo "The record was not inserted due to this error ---> ". mysqli_error($conn);
        }
    }
?>
<!doctype html>
  <head>
    <!-- Bootstrap CSS -->
    <script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <title>CRUD App</title>
  </head>
  <body>
        <!-- Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModal">Edit note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/webProject/index.php?update=true" method="post">
                    <input type="hidden" name="snoEdit" id="snoEdit">
                    <div class="mb-3">
                        <label for="title" class="form-label">Note Title</label>
                        <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">Edit
                        <label for="desc" class="form-label">Note Description</label>
                        <textarea class="form-control" placeholder="Describe your note" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Note</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">CRUD</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">Contact Us</a>
                </li>
            </ul>
            <a href="logout.php">
            <p style="color:white; cursor:pointer;">Logout</p></a>
            </div>
        </div>
    </nav>
    <?php 
        if($insert){
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                <strong>Success!</strong> Your notes has been inserted successfully.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
            ";
        }
    ?>
    <?php 
        if($update){
            echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>Success!</strong> Your notes has been updated successfully.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
            ";
        }
    ?>
    <?php 
        if($delete){
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                <strong>Success!</strong> Your notes has been deleted successfully.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
            ";
        }
    ?>

    <div class="container my-5">
        <h2>Add a note</h2>
        <form action="/webProject/index.php" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Note Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">Note Description</label>
                <textarea class="form-control" placeholder="Describe your note" id="description" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>

    <div class="container" my-4>
        <table class="table" id="myTable">
            <thead>
                <tr>
                <th scope="col">S.No.</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
                        $loggedUser = $_SESSION["username"];
                        $sql = "SELECT * FROM `notes` WHERE user='$loggedUser'";
                        $result = mysqli_query($conn, $sql);
                        $sno = 0;
                        while($row = mysqli_fetch_assoc($result)){
                            $sno ++ ;
                            echo "
                            <tr>
                            <th scope='row'>". $sno . "</th>
                            <td>". $row['title'] . "</td>
                            <td>". $row['description'] . "</td>
                            <td> <button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button> <button type='button' class='delete btn btn-sm btn-danger' id=d".$row['sno'].">Delete</button></td>
                        </tr>
                        ";
                        }
                    ?>
            
            </tbody>
        </table>
    </div>
    <hr>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element)=>{
            element.addEventListener("click", (e)=>{
                tr = e.target.parentNode.parentNode
                title = tr.getElementsByTagName("td")[0].innerText;
                description = tr.getElementsByTagName("td")[1].innerText;
                descriptionEdit.value = description;
                titleEdit.value = title
                snoEdit.value = e.target.id
                $('#editModal').modal('toggle')
            })
        })

        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element)=>{
            element.addEventListener("click", (e)=>{
                sno = e.target.id.substr(1,)
                if(confirm("Are you sure you want to delete it?")){
                    window.location = `/webProject/index.php?delete=${sno}`
                    console.log("yes")
                }
                else{
                    console.log("no")
                }
            })
        })
    </script>
  </body>
</html>