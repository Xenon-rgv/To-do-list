<?php

//database connection
$con = mysqli_connect("localhost", "root", "", "hamplus_first_app");
if (!$con) {
    # code...
    echo '<h1>' . "Not connected" . mysqli_connect_error() . '</h1>';
}
if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $statement = "INSERT INTO my_app (title, description) VALUES ('$title', '$description')";
    $query = mysqli_query($con, $statement);

    if ($query) {
        header("Location: index.php");
    }
    exit();
}




$statement = "SELECT id, title,description FROM my_app ";
$query = mysqli_query($con, $statement);
$todos = mysqli_fetch_all($query, MYSQLI_ASSOC);

if (isset($_POST["delete"])) {
    $id = intval($_POST["id"]);
    $statement = "DELETE FROM my_app WHERE id = $id";
    $query = mysqli_query($con, query: $statement);
}

//for desc edit
$descriptionEditId = null;
if (isset($_POST["descriptionEdit"])) {
    $descriptionEditId = $_POST["id"];
}
if (isset($_POST["update"])) {
    $id = $_POST["id"];
    $description = $_POST["description"];
    $statement = "UPDATE my_app SET description='$description' WHERE id='$id'";
    $query = mysqli_query($con, query: $statement);
    if ($query) {
        header("Location: index.php");
        exit();
    }
}



//for todo edit
$editId = null;
if (isset($_POST["edit"])) {
    $editId = $_POST["id"];
}
if (isset($_POST["update_todo"])) {
    $id = $_POST["id"];
    $title = $_POST["title"];
    $statement = "UPDATE my_app SET title='$title' WHERE id='$id'";
    $query = mysqli_query($con, query: $statement);
    if ($query) {
        header("Location: index.php");
        exit();
    }
}

mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>todo app</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
    <form method="post" name="form" class="container mt-5 form-control">
        <input type="text" name="title" id="title" class="form-control mt-5" placeholder="Enter your todo">
        <input type="text" name="description" id="description" class="form-control mt-5"
            placeholder="Enter your todo description">
        <input type="submit" value="Add" name="add" class="form-control mt-5 btn btn-success mb-3">
    </form>

    <h2 class="text-center mb-4 mt-5">My To-do list</h2>

    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-12 col-md-6 p-3">
            <table class="table table-bordered table-striped table-hover shadow-sm">
                <thead>
                    <tr>
                        <th class="table-dark">Todo</th>
                        <th class="table-dark">description</th>
                        <th style="width: 10%;"></th>
                        <th style="width: 10%;"></th>
                        <th style="width: 10%;"></th>


                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($todos as $todo) { ?>
                        <tr>

                            <td>
                                <?php if ($editId == $todo['id']) { ?>
                                    <form method="post">
                                        <input type="hidden" name="id" value="<?php echo $todo['id']; ?>">
                                        <input type="text" name="title" value="<?php echo $todo['title']; ?>" class="form-control">
                                        <input type="submit" name="update_todo" value="edit-todo" class="btn d-flex mx-auto btn-primary">
                                    </form>
                                <?php } else {
                                    echo $todo['title'];;
                                } ?>
                            </td>

                            <td>
                                <?php if ($descriptionEditId == $todo['id']) { ?>
                                    <form method="post">
                                        <input name="id" hidden value="<?php echo $todo['id'] ?>">
                                        <input type="text" name="description" value="<?php echo $todo['description']; ?>" class="form-control">
                                        <input type="submit" name="update" value="Update" class="btn btn-warning">
                                    </form>
                                <?php } else {
                                    echo $todo['description'];
                                } ?>
                            </td>

                            <td>
                                <form method="post">
                                    <input name="id" type="hidden" value="<?php echo $todo['id']; ?>">
                                    <input type="submit" name="delete" value="delete" class="btn d-flex mx-auto btn-danger">
                                </form>
                            </td>
                            <td>
                                <form method="post">
                                    <input name="id" type="hidden" value="<?php echo $todo['id']; ?>">
                                    <input type="submit" name="edit" value="edit-todo" class="btn d-flex mx-auto btn-primary">
                                </form>
                            </td>
                            <td>
                                <form method="post">
                                    <input name="id" type="hidden" value="<?php echo $todo['id']; ?>">
                                    <input type="submit" name="descriptionEdit" value="edit-description" class="btn d-flex mx-auto btn-primary">
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-3"></div>
    </div>



</body>

</html>