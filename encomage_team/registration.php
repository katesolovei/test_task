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
        <div>
            <h1 style="display: inline;">Add user</h1>
            <button type="submit" name="save" class="btnlink">&#10010 Save</button>
            <a href="index.php"><button type="button" name="back" class="btnlink">&#8656 Back</button></a>
        </div>
        <div style="clear: both;"><hr></div>

        <label for="firstName"><b>First name</b></label>
        <input class="text_input" type="text" placeholder="Enter your First Name" name="firstName" required>

        <label for="lastName"><b>Last Name</b></label>
        <input class="text_input" type="text" placeholder="Last Name" name="lastName" required>


        <label for="email"><b>Email</b></label>
        <input class="text_input" type="email" placeholder="Enter Email" name="email" id="email" required>

        <hr>
        <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>

    </div>
</form>

</body>
</html>

