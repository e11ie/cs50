<?php

    // configuration
    require("../includes/config.php"); 
    
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // if form was empty
        if (empty($_POST["shares"]))
        {
            apologize("No shares were entered.");
        }
        else if (empty($_POST["symbol"]))
        {
            apologize("No symbol was entered.");
        }
        
        // check symbol
        $stock = lookup($_POST["symbol"]);
        if ($stock === false)
        {
            apologize("Invalid symbol. Please try again.");
        }
        
        // if numeric, int, or greater than 0 
        if ((is_numeric($_POST["shares"]) && fmod(floatval($_POST["shares"]), 1) == 0) && $_POST["shares"] > 0)
        {
            // look up cash
            $cash_row = query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
            $cash = $cash_row[0]["cash"];
            
            // is price < cash ??
            if ($cash > ($stock["price"] * $_POST["shares"]))
            {
                // insert into database
                query("INSERT INTO stocks (id, symbol, shares) VALUES(?, ?, ?) 
                    ON DUPLICATE KEY UPDATE shares = shares + VALUES(shares)", $_SESSION["id"], strtoupper ($stock["symbol"]), $_POST["shares"]);
                // update cash
                query("UPDATE users SET cash = cash - ? WHERE id = ?", ($stock["price"] * $_POST["shares"]), $_SESSION["id"]);
                // insert into history
                query("INSERT INTO history (dateTime, buySell, symbol, shares, price, id) VALUES (CURRENT_TIMESTAMP, 'BUY', ?, ?, ?, ?)",
                    strtoupper ($stock["symbol"]), $_POST["shares"], $stock["price"], $_SESSION["id"]);
                // if successfull render portfolio
                redirect("/");
            }
            
            apologize("You cannot afford to buy that amount of shares. Please check the price and try again.");
        }
        
        apologize("The number of shares entered was not valid.");
    }
    else
    {
        // else render form
        render("buy_form.php", ["title" => "Buy"]);
    }

?>
