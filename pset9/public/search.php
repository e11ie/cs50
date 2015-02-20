<?php

    // configuration
    require("../includes/config.php");
    
    //TODO
    
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // TODO
        // vars
        $query = $t = $range = $new_array = array();
        
        $search = $field = $species = $gender = $lat = $lng = $reportedbefore = $reportedafter = $description = "";
        $field = test_input($_POST['field']);
        $species = test_input($_POST['species']);
        $gender = test_input($_POST['gender']);
        
        // if everything was empty
        if (empty($_POST['search']) && empty($_POST['reportedbefore']) && empty($_POST['reportedafter']) && empty($_POST['lat']) 
            && empty($_POST['lng']))
        {
            if ($gender === "gender_none" && $species === "species_none" && $field === "field_none")
            {
                apologize("You should fill in at least one field to search.");
            }
        }
        
        // if both search and field aren't filled out
        if ($field !== "field_none" && $_POST['search'] === "")
        {
            apologize("Please fill out the search box (or return the field you want to search to NONE).");
        }
        else if ($field === "field_none" && $_POST['search'] !== "")
        {
            apologize("Please select a field you want to search in (or delete the words in the search box).");
        }
        else if ($field !== "field_none" && $_POST['search'] !== "")
        {
            if ($field === "description")
            {
                $description = test_input($_POST['search']);
                $regex = new MongoRegex("/$description/i");
                $new_array = array("description" => $regex);
                $query = array_merge($query, $new_array);
            }
            else
            {
                $search = test_input($_POST['search']);
                $regex = new MongoRegex("/$search/i");
                $new_array = array($field => $regex);
                $query = array_merge($query, $new_array);
            }
        }
        // if the species isn't filled out
        if ($species !== "species_none")
        {
            $new_array = array("species" => $species);
            $query = array_merge($query, $new_array);
        }
        
        // if the gender isn't filled out
        if ($gender !== "gender_none")
        {
            $new_array = array("gender" => $gender);
            $query = array_merge($query, $new_array);
        }
        // if the lat is filled out
        if (!empty($_POST['lat']))
        {
            $lat = test_input($_POST["lat"]);
            // check if legit
            if(!preg_match('/([0-9.-]+).+?([0-9.-]+)/', $lat))
            {
                apologize("The latitude you entered is not correct (only a decimal number please!).");
            }
            $regex = new MongoRegex("/$lat/i");
            $new_array = array("lat" => $regex);
            $query = array_merge($query, $new_array);
        }
        // if the lng is filled out
        if (!empty($_POST['lng']))
        {
            $lng = test_input($_POST["lng"]);
            // check if legit
            if(!preg_match('/([0-9.-]+).+?([0-9.-]+)/', $lng))
            {
                apologize("The latitude you entered is not correct (only a decimal number please!).");
            }
            $regex = new MongoRegex("/$lng/i");
            $new_array = array("lng" => $regex);
            $query = array_merge($query, $new_array);
        }
        // if the reported before isn't filled out
        $end =$start = ""; 
        $s = $e = array();
        // Instantiate dates for the range of the query        
        if ($_POST['reportedbefore'] !== "")
        {
            $reportedbefore = test_input($_POST['reportedbefore']);
            // TODO: put it in the $query
            $end = new MongoDate(strtotime("$reportedbefore 23:59:59")); 
            $e = array('$lte' => $end);
        }
        if ($_POST['reportedafter'] !== "")
        {
            $reportedafter = test_input($_POST['reportedafter']);
            // TODO: put it in the $query
            $start = new MongoDate(strtotime("$reportedafter 00:00:00"));
            $s = array('$gt' => $start);
        }
        // if both are set, validate that before is before and after is after
        if ($_POST['reportedafter'] !== "" && $_POST['reportedbefore'] !== "")
        {
            // $a_year = substr($reportedafter, 0, 4);
            // $a_month = substr($reportedafter, 5, -3);
            // $a_day = substr($reportedafter, 8);
            // $b_year = substr($reportedbefore, 0, 3);
            // $b_month = substr($reportedbefore, 5, -3);
            // $b_day = substr($reportedbefore, 8);
            // if (intval($b_year) <= intval($a_year) && intval($b_month) <= intval($a_month) && intval($b_day) <= intval($a_day))
            // {
            //     apologize("Not a valid before and after date.");
            // }
            
            if ($start < $end)
            {
                // $t = array('$gt' => $start, '$lte' => $end);
                // say "yay"?                
            }
            else
            {
                apologize("Not a valid before and after date.");
            }
            
            
        }
        
        // connect to db
        $m = connect();
        $db = $m->$dbname;
        // Get the posters collection
        $c_posters = $db->posters; 
        
        $t = array_merge($s, $e);
        $t = array('reported' => $t);
        $range = $t;
        
        if ($range !== array() )
        {
            $query = array_merge($query, $range);
        }
        $cursor = $c_posters->find($query);
        // sort
        $cursor->sort(array('posted' => 1));
        
        $cursor_count = $c_posters->count($query);
        if($cursor_count < 1)
        {
            apologize("There were no results.");
        }
        // disconnect from server
        $m->close();
        
        render("result_form.php", ["status" => "search", "cursor" => $cursor, "title" => "Search Results"]);
    }
    else
    {
        render("search_form.php", ["title" => "Search"]);
    }
