<?php

    // configuration
    require("../includes/config.php");
    
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["symbol"]))
        {
            apologize("You must provide a investment symbol.");
        }
        
        $stock = lookup($_POST["symbol"]);
        if ($stock === false)
        {
            apologize("Invalid symbol. Please try again.");
        }
                
        // redirect to quote_result.php
        render("quote_result.php", ["stock" => $stock, "title" => "Quote"]);
     }
     
     else
     {
        // else render form
        render("get_quote.php", ["title" => "Get Quote"]);
     }
     
?>
