<?php

    // configuration
    require("../includes/config.php"); 
    
    
    
    // TODO
    
    // if logged in -> user profile page (pass the info like below)
        // query db for user info
        // count number of pets posted
        // query db for pets posted by user
    // make sure profile page has these things:
        // button for viewing posted pets
            // edit
            // delete
        // button for new pet post
        // button to log out
        // button to edit personal info (like contact info)
    if (!empty($_SESSION["username"]))
    {
        // vars
        $query = "";
        $username = $_SESSION["username"];
        // connect to db
        $m = connect();
        $db = $m->$dbname;
        // Get the posters collection
        $c_posters = $db->posters;
        $query = array("username" => $username);
        $cursor = $c_posters->find($query);
        $cursor_count = $c_posters->count($query);
        if($cursor_count < 1)
        {
            $cursor = "no";
        }
	    
	    // disconnect from server
        $m->close();   
        // render profile
        render("profile.php", ["cursor" => $cursor, "title" => "$username Profile"]);
    }
    else
    {
        render("welcome.php", ["title" => "Welcome"]);
    }

?>
