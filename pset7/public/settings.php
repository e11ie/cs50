<?php

    // configuration
    require("../includes/config.php"); 
    
    // TODO
    // change password
    // send receipts?
    
    
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty($_POST["password"]))
        {
            apologize("You must provide a password.");
        }
        if (empty($_POST["confirmation"]))
        {
            apologize("You must confirm your new password.");
        }
        else if ($_POST["password"] !== $_POST["confirmation"])
        {
            apologize("Your password and confirmation must match.");
        }
        
        // update user table
        $result = query("UPDATE users SET hash = ? WHERE id = ?", crypt($_POST["password"]), $_SESSION["id"]);
        if ($result === false)
        {
            // the INSERT failed, presumably because username already existed
            apologize("Password change has failed.");
        }
        
        // if successfull render portfolio
        redirect("/");
    }
    else
    {
        // else render form
        render("settings_form.php", ["title" => "Settings"]);
    }

?>
