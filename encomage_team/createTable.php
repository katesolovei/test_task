<?php

/*CREATE TABLE 'test_encomage_db'.'users' (
    'id' INT(255) NOT NULL AUTO_INCREMENT ,
    `first_name` VARCHAR(30) NOT NULL ,
    `last_name` TEXT NOT NULL ,
    `email` TEXT NOT NULL ,
    `password` TEXT NOT NULL ,
    `create_date` DATETIME(6) NOT NULL ,
    `update_date` DATETIME(6) NOT NULL ,


//include 'config.php';*/

//createTable();

function createTable(){

    $host = DB_HOST;
    $user = DB_USER;
    $pass = DB_PASS;
    $dbName = DB_NAME;
    $dbTable = DB_TABLE;

    $link = mysqli_connect($host, $user, $pass, $dbName);

    $query = "CREATE TABLE $dbName.$dbTable(id INT(255) NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(30) NOT NULL ,
    last_name VARCHAR(30) NOT NULL ,
    email VARCHAR(30) NOT NULL ,
    password VARCHAR(30) NOT NULL ,
    create_date DATETIME(6) NOT NULL,
    update_date DATETIME(6) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (email))";

    if (mysqli_query($link, $query)) {
        echo "Table created successfully with the name '$dbTable'";
    } else {
        echo "Error creating Table: " . mysqli_error($link);
    }

    mysqli_close($link);
}