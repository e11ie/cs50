<?php

    // configuration
    require("../includes/config.php");
    
    $cursor = "";
        
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        
        // define variables and set to empty values
        $reported = $dateReported = $name = $species = $breed = $gender = $weight = $age = $chip = $id = "";
        $primarycolor = $secondarycolor = $description = $phone = $email = $confirm = "";
        
        // validate submission
        if (empty($_POST["name"]))
        {
            $name = "none given";
        }
        else
        {
            $name = test_input($_POST["name"]);
        }
        if (empty($_POST["status"])) //
        {
            apologize("You must say if you found a pet or lost one.");
        }
        else
        {
            $status = test_input($_POST["status"]);
        }
        if (empty($_POST["reported"])) //
        {
            apologize("The date you lost/found your pet is required.");
        }
        else
        {
            $reported = test_input($_POST["reported"]);
            $reported = new MongoDate(strtotime("$reported 00:02:00"));
        }
        if (empty($_POST["lat"])) //
        {
            apologize("The latitude where you lost/found your pet is required.");
            
        }
        else
        {
            $lat = test_input($_POST["lat"]);
            // check if legit
            if(!preg_match('/([0-9.-]+).+?([0-9.-]+)/', $lat))
            {
                apologize("The latitude where you lost/found your pet is not correct (only a decimal number please!).");
            }
        }
        if (empty($_POST["lng"])) //
        {
            apologize("The longitude where you lost/found your pet is required.");
        }
        else
        {
            $lng = test_input($_POST["lng"]);
            // check if legit
            if(!preg_match('/([0-9.-]+).+?([0-9.-]+)/', $lng))
            {
                apologize("The longitude where you lost/found your pet is not correct (only a decimal number please!).");
            }
        }
        if (empty($_POST["species"])) //
        {
            apologize("The species of your pet is required.");
        }
        else
        {
            $species = test_input($_POST["species"]);
        }
        if (empty($_POST["breed"]))
        {
            $breed = "none given";
        }
        else
        {
            $breed =  test_input($_POST["breed"]);
        }
        if (empty($_POST["weight"])) //
        {
            apologize("The weight of your pet is required.");
        }
        else
        {
            $weight = test_input($_POST["weight"]);
        }
        if (empty($_POST["age"]))
        {
            $age = "none given";
        }
        else
        {
            $age =  test_input($_POST["age"]);
        }
        if (empty($_POST["chip"])) //
        {
            apologize("Does your pet have an ID chip?");
        }
        else
        {
            $chip =  test_input($_POST["chip"]);
        }
        if (empty($_POST["id"]))
        {
            $id = "none given";
        }
        else
        {
            $id =  test_input($_POST["id"]);
        }
        if (empty($_POST["gender"])) //
        {
            apologize("Your pets gender is required");
        }
        else
        {
            $gender = test_input($_POST["gender"]);
        }
        if (empty($_POST["primarycolor"])) //
        {
            apologize("Your pets primary color is required");
        }
        else
        {
            $primarycolor = test_input($_POST["primarycolor"]);
        }
        if (empty($_POST["secondarycolor"]))
        {
            $secondarycolor = "none given";
        }
        else
        {
            $secondarycolor =  test_input($_POST["secondarycolor"]);
        }
        if (empty($_POST["description"]))
        {
            $description = "none given";
        }
        else
        {
            $description =  test_input($_POST["description"]);
        }
        if (empty($_POST["phone"])) 
        {
            $phone = "none given";
        }
        else
        {
            $phone = test_input($_POST["phone"]);
            if (!ctype_digit($phone))
            {
                apologize("Invalid phone number! Please make sure there is an area code, are no symbols, and only numbers.");
            }
        }
        if (empty($_POST["email"])) //
        {
            apologize("Your email is required");
        }
        else
        {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                apologoze("This is not a valid email address.");
            }
        }
        if ($_POST["email"] !== $_POST["confirm"]) //
        {
            apologize("Your email and confirmation must match.");
        }
        
        // REQUIRED
        $username = $_SESSION["username"];
        $posted = new MongoDate();
        
        $data = array("username" => $username, "posted" => $posted, "name" => $name, "id" => $id, "status" => $status, 
            "reported" => $reported, "lat" => $lat, "species" => $species, "breed" => $breed, "age" => $age, "gender" => $gender,
            "lng" => $lng, "chip" => $chip, "primarycolor" => $primarycolor, "weight" => $weight, "secondarycolor" => $secondarycolor, 
            "description" => $description, "phone" => $phone, "email" => $email);
        
        
        // connect to db
        $cursor = array();
        $m = connect();
        $db = $m->$dbname;
	    // Get the posters collection
	    $c_posters = $db->posters;
	    // insert into db
	    if ($_POST["petid"] !== "none" && isset($_SESSION["id"])) 
        {
            $id = test_input($_POST["petid"]);
            print_r($_POST["petid"]);
            $query = array("_id" => new MongoId($id));
            // update db
	        $cursor = $c_posters->find($query);
	        $cusor_count = $c_posters->count($query);
	        if ($cursor_count === 1)
	        {
	            $newdata = array('$set' => $data);
	            $c_posters->update($query, $newdata);
            }
        }
        else if ($_POST["petid"] === "none" && isset($_SESSION["id"]))
        {
            $c_posters->insert($data);            
        }
        
        
             //
        
        // disconnect from server
        $m->close();
        
        // TODO
            // pin a map for location lost at!
            // upload a pic
            
        // redirect to profile
        redirect("/");
    }
    else
    {
        // else render form
        render("poster_form.php", ["cursor" => $cursor, "title" => "New Poster"]);
    }
    
?>
