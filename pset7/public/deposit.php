<?php

    // configuration
    require("../includes/config.php"); 
    
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty($_POST["dollars"]))
        {
            apologize("You have not entered any money to deposit.");
        }
        if (is_numeric($_POST["dollars"]) && fmod(floatval($_POST["dollars"]), 1) == 0)
        {
            //change cash in db
            query("UPDATE users SET cash = cash + ? WHERE id = ?", $_POST["dollars"], $_SESSION["id"]);
            
            // if successfull render portfolio
            redirect("/");
        }
        // if not empty or numeric
        apologize("Please only enter whole dollars.");
    }
    else
    {
        // else render form
        render("deposit_form.php", ["title" => "Deposit Cash"]);
    }

?>
