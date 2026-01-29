<?php 

$insert = false;
$update = false;
$delete = false;
// INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, 'I am learning ', 'i will make guestcountry good ', current_timestamp());
 $servername = "localhost";  
    $username = "root";
    $password = "";
    $database = "notes";

    $conn = mysqli_connect($servername, $username, $password, $database);

    if(!$conn) {
        die("Not able to connect: " . mysqli_connect_error());
    }

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['snoEdit'])){
    // Update the record
  $sno = $_POST['snoEdit'];
  $title = $_POST['titleEdit'];
  $description = $_POST['descriptionEdit'];
$sql = "UPDATE `notes` SET `title` = ?, `description` = ? WHERE `notes`.`sno` = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ssi", $title, $description, $sno);
$result = mysqli_stmt_execute($stmt);
if($result){
  $update = true;
}
  }
  else{
  $title = $_POST['title'];
  $description = $_POST['description'];
$sql = "INSERT INTO `notes` (`title`, `description`) VALUES (?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $title, $description);
$result = mysqli_stmt_execute($stmt);
if($result){
  $insert = true;

} else {
  echo "The record was not inserted successfully because of this error ---> " . mysqli_error($conn);

}
  }
}

if(isset($_GET['delete'])){
  $sno = intval($_GET['delete']);
  $sql = "DELETE FROM `notes` WHERE `sno` = ?";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "i", $sno);
  $result = mysqli_stmt_execute($stmt);
  if($result){
    $delete = true;
  }
}

?>


<!doctype html>
<html lang="en" dir="ltr">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.rtl.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link rel="stylesheet" href="//cdn.datatables.net/2.3.6/css/dataTables.dataTables.min.css">
    <script src="//cdn.datatables.net/2.3.6/js/dataTables.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    </script>

    <title>Inotes</title>

</head>

<body>

    <!-- Button trigger modal -->
    <!--<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
Edit Modal
</button> -->

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit this NOte</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/crud/index.php" method="post">
                        <input type="hidden" id="snoEdit" name="snoEdit">
                        <div class="mb-3">
                            <label for="Title" class="form-label">Note Title</label>
                            <input type="text" class="form-control" id="TitleEdit" name="titleEdit"
                                aria-describedby="emailHelp">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Example textarea</label>
                            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit"
                                rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Note</button>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


 

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Inotes</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
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

                    <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <?php
if($insert){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success</strong> Your notes has been added successfully.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
} 
?>

    <?php
if($update){
    
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success</strong> Your notes has been updated successfully.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
} 
?>

    <?php
if($delete){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success</strong> Your notes has been deleted successfully.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
} 
?>




    <div class="container my-4">
        <h2>Add a Note</h2>
        <form action="/crud/index.php" method="post">
            <div class="mb-3">
                <label for="Title" class="form-label">Note Title</label>
                <input type="text" class="form-control" id="Title" name="title" aria-describedby="emailHelp">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Example textarea</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>

    </div>


    <div class="container">


        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>

                <?php 
    $sql = "SELECT * FROM `notes`";
    $result = mysqli_query ($conn, $sql);
    $sno = 0;
    while($row = mysqli_fetch_assoc($result)){
      $sno = $sno + 1;
      echo "<tr>
      <th scope='row'>". $sno . "</th>
      <td>". $row['title'] . "</td>
      <td>". $row['description'] . "</td>
      <td>   <button class='edit btn btn-sm btn-primary' id='".$row['sno']."'>Edit</button> <button class='delete btn btn-sm btn-primary' id='d".$row['sno']."'>Delete</button> </td>
    </tr>";
        
    }
  



    ?>

            </tbody>
        </table>



    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
    -->
    <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("edit ", e.target.parentNode.parentNode);
            tr = e.target.parentNode.parentNode;
            title = tr.getElementsByTagName("td")[0].innerText;
            description = tr.getElementsByTagName("td")[1].innerText;
            console.log(title, description);
            descriptionEdit.value = description;
            snoEdit.value = e.target.id;
            console.log(e.target.id);
            TitleEdit.value = title;
            $('#editModal').modal('toggle');
        })
    });
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
            console.log("delete ", e.target.parentNode.parentNode);
            sno = e.target.id.substr(1, );

            if (confirm("Press a button!")) {
                console.log("yes");
                window.location = `/crud/index.php?delete=${sno}`;
            } else {
                console.log("no");
            }

        })
    });
    </script>
</body>

</html>