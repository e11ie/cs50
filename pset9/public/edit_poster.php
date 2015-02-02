<?php

    // configuration
    require("../includes/config.php"); 
    //TODO
        // merge edit_form and poster_form
    
    if (isset($_GET['id'])) 
    {
        $username = $_SESSION["username"];
        $id = test_input($_GET['id']);
        $cursor = array();
        //$p_id = $_SESSION["posterid"];
        $query = array("_id" => new MongoId($id));
        // connect to db
        $m = connect();
        $db = $m->$dbname;
        // Get the users collection
        $c_posters = $db->posters;
        $cursor = $c_posters->findOne($query);
        $cursor_count = $c_posters->count($query);
        if ($cursor_count == 0)
        {
            apologize("The poster of the pet you were looking for was not found.");
        }
        
        // set title to pet name
        if ($cursor["name"] !== "none given")
        {
            $name = ucwords($cursor["name"]);
        }
        else
        {
            $name = "";
        }
        // disconnect from server
        $m->close();
        // check to see if (the correct) user is logged in
        if ($username !== $cursor["username"])
        {
            apologize("You are not the correct user to edit this poster, or you are not logged in.");
        }
        //render edit form
        render("edit_form.php", ["cursor" => $cursor, "title" => "Edit Poster $name"]);
    }
    else
    {
        //render poster
        render("poster.php", ["cursor" => $cursor, "title" => $name]);
    }
?>
