<?php

include "config.php";
$host = DB_HOST;
$user = DB_USER;
$pass = DB_PASS;
$dbname = DB_NAME;
?>

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
        <?php
        $id = $_GET['id'];?>
        <input type="hidden" name="id" value="<?=$id?>">
        <div>
            <h1 style="display: inline;">Edit user</h1>
            <button type="button" name="save_edit" class="btnlink"><a style="color: white; text-decoration: none;" href="edit.php?id=<?=$id?>&change=1">&#10010 Save and Continue Edit</a></button>
            <button type="submit" name="edit" class="btnlink">&#10010 Save</button>
            <a href="index.php"><button type="button" name="back" class="btnlink">&#8656 Back</button></a>
        </div>
        <div style="clear: both;"><hr></div>
        <?php
        if($_GET['change']=='1'){
            update_user();
        }
            $user = mysqli_fetch_assoc(get_user('id', $id));
        ?>
        <label for="firstName"><b>First name</b></label>
        <input class="text_input" type="text" placeholder="Enter your First Name" name="firstName" value="<?php echo $user['first_name']?>">

        <label for="lastName"><b>Last Name</b></label>
        <input class="text_input" type="text" placeholder="Last Name" name="lastName" value="<?=$user['last_name']?>">


        <label for="email"><b>Email</b></label>
        <input class="text_input" type="email" placeholder="Enter Email" name="email" id="email" value="<?=$user['email']?>">

        <hr>
    </div>
</form>

</body>
</html>

<?php
function update_user($id, $first_name, $last_name, $email, $modified_date){
    $link = connectToDB();

    $query = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', email = '$email', update_date = '$modified_date' WHERE id = '$id'";

    $res = mysqli_query($link, $query);

    if ($res){
        // header("Location: index.php");
    } else{
        //  $result = '';
        $error = 'Sory, something went wrong'.$res;
        echo mysqli_error($link);
    }
}

function get_user($param, $value){
    $link = connectToDB();
    $query = '';
    if(is_array($value)){
        $from = $value['from'];
        $to = $value['to'];
        if($value['from'] AND $value['to']) {
            $query = "SELECT * FROM users WHERE '$param' BETWEEN '$from' AND '$to'";
        } elseif ($from){
            $query = "SELECT * FROM users WHERE '$param' >= '$from'";
        } elseif ($to){
            $query = "SELECT * FROM users WHERE '$param' <= '$to'";
        }
    } else{
        $query = "SELECT * FROM users WHERE $param = '$value'";
    }
    $res = mysqli_query($link, $query);

    if($res){
        return $res;
    } else echo"Can't select users";
}

function connectToDB(){

    $host = DB_HOST;
    $user = DB_USER;
    $pass = DB_PASS;
    $dbname = DB_NAME;
        $link = mysqli_connect($host, $user, $pass, $dbname);

    if ( mysqli_connect_errno() ) {
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }

    return $link;
}
