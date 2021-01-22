<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/search.js"></script>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        .container {
            padding: 16px;
            background-color: white;
        }

        /* Full-width input fields */
        .text_input {
            width: 100%;
            padding: 15px;
            margin: 5px 0 22px 0;
            display: inline-block;
            border: none;
            background: #f1f1f1;
        }

        .text_input:focus {
            background-color: #ddd;
            outline: none;
        }

        hr {
            border: 1px solid #f1f1f1;
            margin-bottom: 25px;
        }

        .btnlink{
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            margin: 4px;
            padding: 10px;
            width: auto;
            display: inline;
            float: right;
            color: white;
            text-decoration: none;
            cursor: pointer;
            border: none;
        }
    </style>
</head>
<body>

<form action="index.php" method="post" name="reg_form">
    <div class="container">
        <?php $id = $_GET['id'];?>
        <input type="hidden" name="id" value="<?=$id?>">
        <div>
            <h1 style="display: inline;">Edit user</h1>
            <button type="button" name="save_edit" class="btnlink"><a style="color: white; text-decoration: none;" href="registration.php">&#10010 Save and Continue Edit</a></button>
            <button type="submit" name="edit" class="btnlink">&#10010 Save</button>
            <a href="index.php"><button type="button" name="back" class="btnlink">&#8656 Back</button></a>
        </div>
        <div style="clear: both;"><hr></div>

        <label for="firstName"><b>First name</b></label>
        <input class="text_input" type="text" placeholder="Enter your First Name" name="firstName">

        <label for="lastName"><b>Last Name</b></label>
        <input class="text_input" type="text" placeholder="Last Name" name="lastName">


        <label for="email"><b>Email</b></label>
        <input class="text_input" type="email" placeholder="Enter Email" name="email" id="email">

        <hr>
    </div>
</form>

</body>
</html>

<?php
include "config.php";

$error='';

/**
 * @param string $userPassword
 * @param string $passwordRepeat
 * @param string[] $error
 */
function update_user($first_name, $last_name, $email, $create_date, $update_date){
    $link = connectToDB();
if($link){
    echo "OK";
} else echo "not Ok";
    $query = "INSERT INTO users(first_name, last_name, email, create_date, update_date) VALUES ('$first_name','$last_name','$email', '$create_date', '$update_date')";

    $res = mysqli_query($link, $query);

    if ($res){
       // header("Location: index.php");
    } else{
      //  $result = '';
        $error = 'Sory, something went wrong';
        echo $error;
    }
    //return $result;
}
//function connectToDB(){
//    $host = DB_HOST;
//    $user = DB_USER;
//    $pass = DB_PASS;
//    $dbname = DB_NAME;
//
//    $link = mysqli_connect($host, $user, $pass, $dbname);
//
//    if ( mysqli_connect_errno() ) {
//        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
//    }
//
//    return $link;
//}
