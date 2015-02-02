<?php

    // configuration
    require("../includes/config.php"); 
    
     
    
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        
        if (isset($_GET['id'])) 
        {
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
            
            // set title
            $name = ucwords($cursor["name"]);
            
            // disconnect from server
            $m->close();
            
        }
        render("poster_pet.php", ["cursor" => $cursor, "title" => $name]);
    }
    else
    {
        apologize("The poster of the pet you were looking for was not found.");
    }
?>
