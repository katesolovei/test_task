<?php
include "config.php";

date_default_timezone_set('Europe/Kiev');

$dbHost = DB_HOST;
$dbUser = DB_USER;
$dbPass = DB_PASS;
$dbName = DB_NAME;
$dbTable = DB_TABLE;

$users = [];
$action = '';

$users = get_users();

if(isset($_POST['search_submit'])){
    $search_id = test_input($_POST['sId']);
    $search_first_name = test_input($_POST['sFirstName']);
    $search_last_name = test_input($_POST['sLastName']);
    $search_email = test_input($_POST['sEmail']);
    $date_create['from'] = test_input($_POST['createdFrom']);
    $date_create['to'] = test_input($_POST['createdTo']);
    $date_modified['from'] = test_input($_POST['modifiedFrom']);
    $date_modified['to'] = test_input($_POST['modifiedTo']);
    header('Location: index.php');
}

?>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="css\style.css">
    </head>

    <body>
    <?php
    if (isset($_POST['save'])){
        $first_name = test_input($_POST['firstName']);
        $last_name = test_input($_POST['lastName']);
        $email = test_input($_POST['email']);
        $create_date = date('Y-m-d H:i:s');
        $modified_date = date('Y-m-d H:i:s');
        save_user($first_name, $last_name, $email, $create_date, $modified_date);

        echo "<span><centre><h3>$first_name $last_name thanks for registering on our website</h3></centre></p>";

        //header('Location: index.php');
    }
    if (isset($_POST['edit'])){
        $id = $_POST['id'];
        $user_info = mysqli_fetch_assoc(get_user('id',$id));
        var_dump($user_info);
        if (!empty($_POST['firstName'])) {
            $first_name = test_input($_POST['firstName']);
        } else {
            $first_name = $user_info['first_name'];
        }
        if (!empty($_POST['lastName'])) {
            $last_name = test_input($_POST['lastName']);
        } else {
            $last_name = $user_info['last_name'];
        }
        if (!empty($_POST['email'])){
            $email = test_input($_POST['email']);
        } else {
            $email = $user_info['email'];
        }
        $modified_date = date('Y-m-d H:i:s');
        update_user($id, $first_name, $last_name, $email, $modified_date);

        //header('Location: index.php');
    }
    ?>
    <form method="post">
        <div class="container">
            <div>
                <h1 style="display: inline;">User list</h1>
                <a class="btnlink" href="registration.php"><button type="button" class="registerbtn">&#10010 Add User</button></a>
            </div>
            <div style="clear: both;"><hr></div>
            <table>
                <th style="width:10%"><a href="sort('id')">ID</a></th>
                <th style="width:16%"><a href="sort('id')">First Name</a></th>
                <th style="width:16%"><a href="sort('id')">Last Name</a></th>
                <th style="width:16%"><a href="sort('id')">Email</a></th>
                <th style="width:16%"><a href="sort('id')">Date Created</a></th>
                <th style="width:16%"><a href="sort('id')">Last Modified</a></th>
                <th style="width:10%">Action</th>
                <tbody>
                <tr>
                    <td class="cell">
                        <input type="text" name="sId" class="input" id="sId">
                    </td>
                    <td class="cell">
                        <input type="text" name="sFirstName" class="input" id="sFirstName">
                    </td>
                    <td class="cell">
                        <input type="text" name="sLastName" class="input" id="sLastName">
                    </td>
                    <td class="cell">
                        <input type="email" name="sEmail" class="input" id="sEmail">
                    </td>
                    <td class="cell">
                        <div class="date_cls">
                            <label for="createdFrom"">From</label>
                            <input type="datetime-local" name="createdFrom" id="createdFrom" class="date_time">
                        </div>
                        <div class="date_cls">
                            <label>To</label>
                            <input type="datetime-local" name="createdTo" id="createdTo" class="date_time">
                        </div>
                    </td>
                    <td>
                        <div class="date_cls">
                            <label for="modifiedFrom">From</label>
                            <input type="datetime-local" name="modifiedFrom" id="modifiedFrom" class="date_time">
                        </div>
                        <div class="date_cls">
                            <label for="modifiedTo">To</label>
                            <input type="datetime-local" name="modifiedTo" id="modifiedTo" class="date_time">
                        </div>
                    </td>
                    <td></td>
                </tr>
                <?php
                $users = get_users();
                if(isset($_POST['search_submit'])){
                    if(!empty($search_id)){
                        $users = get_user('id', $search_id);
                    }
                    if(!empty($search_first_name)){
                        $users = get_user('first_name', $search_first_name);
                        var_dump($users);
                    }
                    if(!empty($search_last_name)){
                        $users = get_user('last_name', $search_last_name);
                    }
                    if(!empty($search_email)){
                        $users = get_user('email', $search_email);
                    }
                    if(!empty($date_create)){
                        $users = get_user('create_date', $date_create);
                    }
                    if(!empty($date_modified)){
                        $users = get_user('update_date', $date_modified);
                    }
                    var_dump($users);

//                    get_user($param, $value);
                }
                if($users){
                    while($user = mysqli_fetch_assoc($users)){
                        $id = $user['id'];
                        echo "<tr><td>".$user['id']."</td>";
                        echo '<td>'.$user['first_name'].'</td>';
                        echo "<td>".$user['last_name']."</td>";
                        echo "<td>".$user['email']."</td>";
                        echo "<td>".$user['create_date']."</td>";
                        echo "<td>".$user['update_date']."</td>";
                        echo "<td><a href='edit.php?id=$id'class='edit'>Edit</a></td></tr>";
                        // include "edit.php";
                    }
                }
                ?>
                </tbody>
            </table>
            <button type="submit" class="registerbtn" id="search" name="search_submit">Submit</button>
            <button type="reset" class="registerbtn">Reset</button>
            <input type="text" name="new" value="new" hidden>
        </div>
    </form>

    </body>
    </html>

<?php

if(checkDB($dbName)){
    createDB($dbHost, $dbUser, $dbPass, $dbName);
    if(!checkDB($dbName)){
        error();
    }
}

if(checkTable($dbTable)) {
    createTable($dbHost, $dbUser, $dbPass, $dbName, $dbTable);
    if(!checkTable($dbTable)){
        error();
    }
}

function get_users(){
    $link = connectToDB();

    $query = "SELECT * FROM users";

    $res = mysqli_query($link, $query);

    if($res){
        return $res;
    } else echo"Can't select users";
}

function save_user($first_name, $last_name, $email, $create_date, $update_date){
    $link = connectToDB();

    $query = "INSERT INTO users(first_name, last_name, email, create_date, update_date) VALUES ('$first_name', '$last_name', '$email', '$create_date', '$update_date')";

    $res = mysqli_query($link, $query);

    if ($res){
        // header("Location: index.php");
    } else{
        //  $result = '';
        $error = 'Sory, something went wrong'.$res;
        echo mysqli_error($link);
    }
}

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
print ($query);
    $res = mysqli_query($link, $query);

    if($res){
        return $res;
    } else echo"Can't select users";
}

function error(){
    echo "Sorry, something went wrong";
    //die();
}

function createDB($dbHost, $dbUser, $dbPass, $dbName){

    $link = mysqli_connect($dbHost, $dbUser, $dbPass);

    $query = "CREATE DATABASE $dbName";
    if (mysqli_query($link, $query)) {
        echo "Database created successfully with the name '$dbName'";
    } else {
        echo "Error creating database: " . mysqli_error($link);
    }

    mysqli_close($link);
}

function createTable($dbHost, $dbUser, $dbPass, $dbName, $dbTable){

    $link = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

    $query = "CREATE TABLE $dbName.$dbTable(id INT(255) NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(30) NOT NULL ,
    last_name VARCHAR(30) NOT NULL ,
    email VARCHAR(30) NOT NULL ,
    create_date VARCHAR(30) NOT NULL,
    update_date VARCHAR(30) NOT NULL,
    PRIMARY KEY (id))";

    if (mysqli_query($link, $query)) {
        echo "Table created successfully with the name '$dbTable'";
    } else {
        echo "Error creating Table: " . mysqli_error($link);
    }

    mysqli_close($link);
}

function checkDB($name){
    $link = connectToDB();
    $query = "SHOW DATABASES LIKE '$name'";

    $result = mysqli_query($link, $query);

    $result?$res=false:$res=true;
    return $res;
}

function checkTable($name){
    $link = connectToDB();
    $query = "SELECT 1 FROM $name";

    $result = mysqli_query($link, $query);

    $result?$res=false:$res=true;
    return $res;
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
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