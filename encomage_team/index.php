<?php
include "config.php";

date_default_timezone_set('Europe/Kiev');
error_reporting(E_ERROR | E_PARSE);
$dbHost = DB_HOST;
$dbUser = DB_USER;
$dbPass = DB_PASS;
$dbName = DB_NAME;
$dbTable = DB_TABLE;

/*Check if DataBase exist
if no - Create DataBase*/
if (checkDB($dbName)) {
    createDB($dbHost, $dbUser, $dbPass, $dbName);
}


/*Check if table users exist
if no - create table users */
if (checkTable($dbTable)) {
    createTable($dbHost, $dbUser, $dbPass, $dbName, $dbTable);
}

/*Check if sort_prop (table with options - order - for sorting columns) exist
if no - create table sort_prop */
if (checkTable('sort_prop')) {
    createTableSort($dbHost, $dbUser, $dbPass, $dbName, 'sort_prop');
}


//$change = false;
$users = [];
$search_data = [];
$check_id = [];
$action = '';
$fields = ['id', 'first_name', 'last_name', 'email', 'create_date', 'update_date'];
//
//$users = get_users();
if (isset($_POST['new'])) {
    $search_id = test_input($_POST['sId']);
    $search_first_name = test_input($_POST['sFirstName']);
    $search_last_name = test_input($_POST['sLastName']);
    $search_email = test_input($_POST['sEmail']);
    $date_create['from'] = str_replace('T', ' ', test_input($_POST['createdFrom']));
    $date_create['to'] = str_replace('T', ' ', test_input($_POST['createdTo']));
    $date_modified['from'] = str_replace('T', ' ', test_input($_POST['modifiedFrom']));
    $date_modified['to'] = str_replace('T', ' ', test_input($_POST['modifiedTo']));
}

?>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="css\style.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
        <script type="text/javascript" src="js\search.js"></script>
        <script type="text/javascript" src="js\sort.js"></script>
    </head>

    <body>
    <?php
    if (isset($_POST['save'])) {
        $first_name = test_input($_POST['firstName']);
        $last_name = test_input($_POST['lastName']);
        $email = test_input($_POST['email']);
        $create_date = date('Y-m-d H:i:s');
        $modified_date = date('Y-m-d H:i:s');
        save_user($first_name, $last_name, $email, $create_date, $modified_date);

        echo "<span><centre><h3>$first_name $last_name thanks for registering on our website</h3></centre></p>";
        update_order($fields, true);
        header('Location: index.php');
    }
    if (isset($_POST['edit'])) {
        $id = $_POST['id'];
        $user_info = mysqli_fetch_assoc(get_user('id', $id));
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
        if (!empty($_POST['email'])) {
            $email = test_input($_POST['email']);
        } else {
            $email = $user_info['email'];
        }
        $modified_date = date('Y-m-d H:i:s');
        update_user($id, $first_name, $last_name, $email, $modified_date);
        update_order($fields, true);
    }
    ?>
    <form method="post">
        <div class="container">
            <div>
                <h1 style="display: inline;">User list</h1>
                <a class="btnlink" href="registration.php">
                    <button type="button" class="registerbtn">&#10010 Add User</button>
                </a>
            </div>
            <div style="clear: both;">
                <hr>
            </div>
            <table>
                <th style="width:10%"><a href="index.php?sort=id" class="sort" id="sort_id">ID</a>
                </th>
                <th style="width:17%"><a href="index.php?sort=first_name" class="sort"
                                         id="sort_f_name">First Name</a>
                </th>
                <th style="width:17%"><a href="index.php?sort=last_name" class="sort"
                                         id="sort_l_name">Last Name</a>
                </th>
                <th style="width:17%"><a href="index.php?sort=email" class="sort"
                                         id="sort_email">Email</a></th>
                <th style="width:13%"><a href="index.php?sort=create_date" class="sort"
                                         id="sort_d_create">Date
                        Created</a></th>
                <th style="width:13%"><a href="index.php?sort=update_date" class="sort"
                                         id="sort_l_modified">Last
                        Modified</a></th>
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
                if (isset($_POST['new'])) {
                    update_order($fields, true);
                    $search_data = [];
                    if ($search_id != '') {
                        $search_data['param'][] = 'id';
                        $search_data['value'][] = $search_id;
                        $_GET['change'] = 'id';
                    }
                    if ($search_first_name != '') {

                        $search_data['param'][] = 'first_name';
                        $search_data['value'][] = $search_first_name;
                        $change = true;
                    }
                    if ($search_last_name != '') {

                        $search_data['param'][] = 'last_name';
                        $search_data['value'][] = $search_last_name;
                        $change = true;
                    }
                    if ($search_email != '') {
                        $search_data['param'][] = 'email';
                        $search_data['value'][] = $search_email;
                        $change = true;
                    }
                    if (($date_create['from'] != '') or ($date_create['to'] != '')) {
                        $search_data['param'][] = 'create_date';
                        $search_data['value'][] = $date_create;
                        $change = true;
                    }
                    if (($date_modified['from'] != '') or ($date_modified['to'] != '')) {

                        $search_data['param'][] = 'update_date';
                        $search_data['value'][] = $date_modified;
                        $change = true;
                    }
                }

                if (!$change) $users = get_users();
                else $users = get_user($search_data['param'], $search_data['value']);

                $param = $_GET['sort'];

                if ($_POST['search_submit']) {
                    if (is_array($users)) {
                        foreach ($users as $us) {
                            if (isset($param)) sort_col($param);
                            else print_users($us, $search_data);
                        }

                    } else {
                        if (isset($param)) sort_col($param);
                        else print_users($users, $search_data);
                    }
                } else {
                    if (isset($param)) sort_col($param);
                    else print_users($users, $search_data);
                }
                ?>
                </tbody>
            </table>
            <button class="registerbtn" id="search" name="search_submit">Submit</button>
            <a href="index.php" class="btnlink">
                <button type="button" class="registerbtn">Reset</button>
            </a>
            <input type="text" name="new" value="new" hidden>
        </div>
    </form>

    </body>
    </html>

<?php
/*function for sort realization*/
function sort_col($param)
{
    $order = get_order($param)[$param]; // get sort order true -  ASC, or false -  DESC
    $res = get_user('print', true); // get list of printed users

    while ($tmp = mysqli_fetch_assoc($res)) $arr[] = $tmp;
// sorting users
    if ($order) {
        usort($arr, function ($item1, $item2) use ($param) {
            return $item1[$param] <=> $item2[$param];
        });
        $order = false;
    } else {
        usort($arr, function ($item1, $item2) use ($param) {
            return $item2[$param] <=> $item1[$param];
        });
        $order = true;
    }
// print sorted users
    foreach ($arr as $array) {
        print_html($array);
    }
// change sorting option
    update_order($param, $order);

}

/*function to get sorting order*/
function get_order($param)
{
    $link = connectToDB();

    $query = "SELECT $param FROM sort_prop";

    $res = mysqli_query($link, $query);

    $result = mysqli_fetch_array($res);
    if ($res) {
        return $result;
    } else echo "Can't select users";
}


/*function for changing sorting option (order)*/
function update_order($param, $status)
{
    $link = connectToDB();

    if (is_array($param)) {
        foreach ($param as $par) {
            $query = "UPDATE sort_prop SET $par = '$status'";

            $res = mysqli_query($link, $query);
        }
    } else {
        $query = "UPDATE sort_prop SET $param = '$status'";

        $res = mysqli_query($link, $query);
    }

    if ($res) {
    } else {
        echo mysqli_error($link);
    }
}

/*Get all users from DataBase*/
function get_users()
{
    $link = connectToDB();

    $query = "SELECT * FROM users";

    $res = mysqli_query($link, $query);

    if ($res) {
        return $res;
    } else echo "Can't select users";
}

/*Get user, who has searched params*/
function get_user($param1, $value1)
{
    $link = connectToDB();
    // if several params were input
    if (is_array($param1)) {
        $len = count($param1);
        for ($i = 0; $i < $len; $i++) {
            $param = $param1[$i];
            $value = $value1[$i];
            if (is_array($value)) {
                $param = $param1[$i];
                $from = $value['from'];
                $to = $value['to'];
                if ($value['from'] and $value['to']) {
                    $query = "SELECT * FROM users WHERE $param BETWEEN '$from' AND '$to'";
                } elseif ($from) {
                    $query = "SELECT * FROM users WHERE $param > '$from'";
                } elseif ($to) {
                    $query = "SELECT * FROM users WHERE $param <= '$to'";
                }
            } else {
                $query = "SELECT * FROM users WHERE $param = '$value'";
            }
            $res = mysqli_query($link, $query);
        }
    } else {
        $param = $param1;
        $value = $value1;
        if (is_array($value)) {
            $from = $value['from'];
            $to = $value['to'];
            if ($value['from'] and $value['to']) {
                $query = "SELECT * FROM users WHERE $param BETWEEN '$from' AND '$to'";
            } elseif ($from) {
                $query = "SELECT * FROM users WHERE $param > '$from'";
            } elseif ($to) {
                $query = "SELECT * FROM users WHERE $param <= '$to'";
            }
        } else {
            $query = "SELECT * FROM users WHERE $param = '$value'";
        }
        $res = mysqli_query($link, $query);
    }

    if ($res) {
        return $res;
    } else echo "Can't select users";
}

/*Preaparing list of users (result of search) to print*/
function print_users($users, $search_data)
{
    foreach ($users as $user) {
        $result[] = $user;
        $count = 0;
        $len = count($search_data);
        for ($i = 0; $i < $len; $i++) {
            if ($i == $len) break;
            if (($search_data['param'][$i] == 'create_date') || ($search_data['param'][$i] == 'update_date')) {
                $count++;
            } else {
                if ($user[$search_data['param'][$i]] == $search_data['value'][$i]) {
                    $result = $user;
                    $count++;
                }
            }
        }
        if ($len == $count) {
            $result1[] = $user['id'];
            $len = count($result1);
            for ($i = 0; $i < $len; $i++) {
                $res[] = $result1[$i];
            }
        }
    }
    $res = array_unique($res);
    foreach ($res as $re) {
        $lot = get_user('id', $re);
        $user = mysqli_fetch_assoc($lot);
        $printed_id[] = $user['id'];
        print_html($user);
    }
    $all_users = get_users();
    while ($tmp = mysqli_fetch_assoc($all_users)) $all_users_array[] = $tmp['id'];

    foreach ($all_users_array as $id) {
        if (in_array($id, $printed_id)) continue;
        else update_print_stat($id, false);
    }
}

/*HTML code generating*/
function print_html($user)
{
    echo "<tr><td class='output'>" . $user['id'] . "</td>";
    echo "<td class='output'>" . $user['first_name'] . '</td>';
    echo "<td class='output'>" . $user['last_name'] . "</td>";
    echo "<td class='output'>" . $user['email'] . "</td>";
    echo "<td class='output'>" . $user['create_date'] . "</td>";
    echo "<td class='output'>" . $user['update_date'] . "</td>";
    echo "<td><a href='edit.php?id=" . $user['id'] . "'class='edit'>Edit</a></td></tr>";
    update_print_stat($user['id'], true);
}

/*Changing print status (printed on the page - true< else - false)*/
function update_print_stat($id, $status)
{
    $link = connectToDB();

    $query = "UPDATE users SET print = '$status' WHERE id = '$id'";

    $res = mysqli_query($link, $query);

    if ($res) {
    } else {
        echo mysqli_error($link);
    }
}

/*Saving user to DataBase*/
function save_user($first_name, $last_name, $email, $create_date, $update_date)
{
    $link = connectToDB();

    $query = "INSERT INTO users(first_name, last_name, email, create_date, update_date, print) VALUES ('$first_name', '$last_name', '$email', '$create_date', '$update_date', true)";

    $res = mysqli_query($link, $query);

    if ($res) {
    } else {
        echo mysqli_error($link);
    }
}

/*Updating user information after changing*/
function update_user($id, $first_name, $last_name, $email, $modified_date)
{
    $link = connectToDB();

    $query = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', email = '$email', update_date = '$modified_date' WHERE id = '$id'";

    $res = mysqli_query($link, $query);

    if ($res) {
        // header("Location: index.php");
    } else {
        //  $result = '';
        $error = 'Sory, something went wrong' . $res;
        echo mysqli_error($link);
    }
}

/*Error message*/
function error()
{
    echo "Sorry, something went wrong";
}

/*Creating DataBase*/
function createDB($dbHost, $dbUser, $dbPass, $dbName)
{

    $link = mysqli_connect($dbHost, $dbUser, $dbPass, "", "3306");

    $query = "CREATE DATABASE $dbName";
    if (mysqli_query($link, $query)) {
        echo "Database created successfully with the name '$dbName'";
    } else {
        echo "Error creating database: " . mysqli_error($link);
    }

    mysqli_close($link);
}

/*Creating table users*/
function createTable($dbHost, $dbUser, $dbPass, $dbName, $dbTable)
{

    $link = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

    $query = "CREATE TABLE $dbName.$dbTable(id INT(255) NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(30) NOT NULL ,
    last_name VARCHAR(30) NOT NULL ,
    email VARCHAR(30) NOT NULL ,
    create_date VARCHAR(30) NOT NULL,
    update_date VARCHAR(30) NOT NULL,
    print BOOLEAN NOT NULL,
    PRIMARY KEY (id))";

    if (mysqli_query($link, $query)) {
        echo "Table created successfully with the name '$dbTable'";
    } else {
        echo "Error creating Table: " . mysqli_error($link);
    }

    mysqli_close($link);
}

/*Creating table with options for sort realisation
and setting default order values - true - ASC sort*/
function createTableSort($dbHost, $dbUser, $dbPass, $dbName, $dbTable)
{

    $link = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

    $query = "CREATE TABLE $dbName.$dbTable ( 
        id BOOLEAN NOT NULL DEFAULT TRUE, 
        first_name BOOLEAN NOT NULL DEFAULT TRUE , 
        last_name BOOLEAN NOT NULL DEFAULT TRUE , 
        email BOOLEAN NOT NULL DEFAULT TRUE , 
        create_date BOOLEAN NOT NULL DEFAULT TRUE , 
        update_date BOOLEAN NOT NULL DEFAULT TRUE )";

    if (mysqli_query($link, $query)) {
        echo "Table created successfully with the name '$dbTable'";
    } else {
        echo "Error creating Table: " . mysqli_error($link);
    }
    $query = "INSERT INTO $dbTable(first_name, last_name, email, create_date, update_date) VALUES (true, true, true, true, true)";
    if (mysqli_query($link, $query)) {
        echo "Table created successfully with the name '$dbTable'";
    } else {
        echo "Error creating Table: " . mysqli_error($link);
    }
    mysqli_close($link);
}

/*Checking if DataBase exists*/
function checkDB($name)
{
    $host = DB_HOST;
    $user = DB_USER;
    $pass = DB_PASS;

    $link = mysqli_connect($host, $user, $pass);

    $query = "SHOW DATABASES LIKE '$name'";

    $result = mysqli_query($link, $query);
    $result = mysqli_fetch_array($result);
    $result ? $res = false : $res = true;
    return $res;
}

/*Checking if table exists*/
function checkTable($name)
{
    $link = connectToDB();
    $query = "SELECT 1 FROM $name";

    $result = mysqli_query($link, $query);

    $result ? $res = false : $res = true;
    return $res;
}

/*Processing of input data*/
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/*Connect to DataBase*/
function connectToDB()
{
    $host = DB_HOST;
    $user = DB_USER;
    $pass = DB_PASS;
    $dbname = DB_NAME;

    $link = mysqli_connect($host, $user, $pass, $dbname);

    if (mysqli_connect_errno()) {
        exit('Failed to connect to MySQL: ' . mysqli_connect_error());
    }

    return $link;
}