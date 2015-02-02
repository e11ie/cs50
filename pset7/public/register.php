<?php

    // configuration
    require("../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["username"]))
        {
            apologize("You must provide a username.");
        }
        else if (empty($_POST["password"]))
        {
            apologize("You must provide a password.");
        }
        else if ($_POST["password"] !== $_POST["confirmation"])
        {
            apologize("Your password and confirmation must match.");
        }
        
        // insert new user into table
        $result = query("INSERT INTO users (username, hash, cash) VALUES(?, ?, 10000.00)", $_POST["username"], crypt($_POST["password"]));
        if ($result === false)
        {
            // the INSERT failed, presumably because username already existed
            apologize("Registration failed. This username may already be in use, so please type in a different username and try again.");
        }
        
        $rows = query("SELECT LAST_INSERT_ID() AS id");
        $id = $rows[0]["id"];
        
        // remember that user's now logged in by storing user's ID in session
        $_SESSION["id"] = $id;
        

        // redirect to portfolio
        redirect("/");

        // TODO
    }
    else
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

?>
