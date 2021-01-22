<?php

//include 'config.php';
//db_create();
/**
 * Creating Data Base
 */
function createDB(){
    $host = DB_HOST;
    $user = DB_USER;
    $pass = DB_PASS;
    $dbName = DB_NAME;

    $link = mysqli_connect($host, $user, $pass);

    $query = "CREATE DATABASE $dbName";
    if (mysqli_query($link, $query)) {
        echo "Database created successfully with the name '$dbName'";
    } else {
        echo "Error creating database: " . mysqli_error($link);
    }

    mysqli_close($link);
}
<style>
body {
    font-family: Arial, Helvetica, sans-serif;
        /*background-color: black;*/
    }

    * {
    box-sizing: border-box;
    }

    /* Add padding to containers */
    .container {
    padding: 16px;
        background-color: white;
    }

    /* Full-width input fields */
    .input{
    width: 100%;
    padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    table, th, td{
    vertical-align: center;
        border: 1px solid black;
    }

    th{
    background: #bfbebe;
}

    .date_cls{
    font-family: cursive;
        font-weight: bold;
        height: 40px;
        margin: 0px 2px 0px 0px;
    }

    .date_time{
    border: none;
    background: #f1f1f1;
    width: 75%;
    float: right;
    padding: 5px;
        margin: 5px;
        display: inline;
    }

    .input:focus {
    background-color: #ddd;
        outline: none;
    }

    /* Overwrite default styles of hr */
    hr {
    border: 2px solid #f1f1f1;
        margin-bottom: 25px;
    }

    /* Set a style for the submit button */
    .registerbtn {
    background-color: #4CAF50;
        color: white;
        padding: 16px 20px;
        margin: 10px 0;
        border-radius: 5px;
        cursor: pointer;
        width: 15%;
        opacity: 0.9;
        display: inline-block;
        float: right;
    }

    .registerbtn:hover {
    opacity: 1;
}

    /* Add a blue text color to links */
    th a {
    color: #000203;
    text-decoration: none;
    }

    .btnlink{
    color: white;
    text-decoration: none;
    }

    .edit{
    color: orange;
    text-decoration: underline;
    }

    /* Set a grey background color and center the text of the "sign in" section */
    .signin {
    background-color: #f1f1f1;
        text-align: center;
    }
</style>