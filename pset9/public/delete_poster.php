<?php

    // configuration
    require("../includes/config.php"); 
    
     
    
    
    if (isset($_GET['id'])) 
    {
        $id = test_input($_GET['id']);
        $username = $_SESSION["username"];
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
        
        // check to see if logged in correctly
        if ($username === $cursor["username"])
        {
            //delete from db
            $c_posters->remove($query);
            //redirect to profile
            redirect("/");
        }
        
        // disconnect from server
        $m->close();
        apologize("You are not the correct user to delete this poster.");
    }
    else
    {
        // redirect to profile
        redirect("/");
    }
?>
