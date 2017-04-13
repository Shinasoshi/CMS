

<?php

if (isset($_POST['create_user'])){


    $username = $_POST['username'];
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];

//    $post_image = $_FILES['image']['name'];
//    $post_image_temp = $_FILES['image']['tmp_name'];

    $user_email = $_POST['user_email'];
    $user_role = $_POST['user_role'];
    $user_password = $_POST['user_password'];
//    $post_date = date('d-m-y');
//
//    move_uploaded_file($post_image_temp , "../images/$post_image");

    $query = "INSERT INTO users(username, user_password, user_firstname, user_lastname, user_email, user_role) ";
    $query .="VALUES('{$username}','{$user_password}','{$user_firstname}','{$user_lastname}','{$user_email}','{$user_role}')";

    $create_user_query = mysqli_query($connection, $query);

    confirm($create_user_query);
    echo "User ".$username." has been added!";
}


?>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>

    <div class="form-group">
        <select name="user_role" id="">
            <option value="subscriber">Select Options</option>
            <option value='admin'>Admin</option>

            <option value='subscriber'>Subscriber</option>


        </select>
    </div>


    <!--    <div class="form-group">-->
    <!--        <label for="post_image">Post Image</label>-->
    <!--        <input type="file" name="image">-->
    <!--    </div>-->

    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_user" value="Add User">
    </div>


</form>