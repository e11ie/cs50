<?php

    // configuration
    require("../includes/config.php");
    
    // var
    $cursor_count = 0;
    // if form was submitted
    if (isset($_GET['status']) || isset($_POST["lala"])) 
    {
            
        // vars
        if (isset($_POST["lala"]))
        {
            $status = $_POST["lala"];
        }
        $query = "";
        $title = "";
        // connect to db
        $m = connect();
        $db = $m->$dbname;
        // Get the posters collection
        $c_posters = $db->posters;
        //vars
        if (isset($_GET['status']))
        {
            $status = $_GET['status'];
        }
        if ($status === "found")
        {
            // set title of page
            $title = "Found";
            // set query
            $query = array("status" => "found");
        }
        else if ($status === "lost")
        {
            // set title of page
            $title = "Lost";
            // set query
            $query = array("status" => "lost");
        }
        else
        {
            $status = "search";
        }
        // var
        $r = $q = $p = $sort = $sort_field = "";
        // if a filter was submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            // set field and sort
            if ($_POST["field"] !== "field_none" && $_POST["ascdesc"] !== "ascdesc_none")
            {
                $sort_field = test_input($_POST["field"]);
                $sort = test_input($_POST["ascdesc"]);
                if($sort === "asc")
                {
                    $sort = 1;
                }
                else
                {
                    $sort = -1;
                }
                $p = array($sort_field => $sort);
            }
            
            if ($_POST["species"] !== "species_none")
            {
                $q = test_input($_POST["species"]);
                $new_array = array("species" => $q);
                $query = array_merge($query, $new_array);
            }
            if ($_POST["gender"] !== "gender_none")
            {
                $r = test_input($_POST["gender"]);
                $new_array = array("gender" => $r);
                $query = array_merge($query, $new_array);
            }
        }
        // if sort isn't specified
        if ($p === "")
        {
            $p = array('posted' => 1);
        }
        $cursor = $c_posters->find($query);
        $cursor_count = $c_posters->count($query);
        $cursor->sort($p);
        if($cursor_count < 1)
        {
            apologize("There were no results.");
        }
        // disconnect from server
        $m->close();
        // render results
        render("result_form.php", ["status" => $status, "cursor" => $cursor, "title" => "$title Results"]);
    }
    else
    {
        // redirect to profile
        redirect("/");
    }
    
    
    // TODO
        // find all documents from a collection (that fits the search or filters)
        // limit to 20 (set to user option?) 
            // paginate the results, so when user clicks on 2 it will go to the next one 
            // and if it clicks to the last one the cursor will go to the last chunck
        // search
            // everything
            // in a specific category
            // before or after a date
        // filter
            // by category
        

    

?>
