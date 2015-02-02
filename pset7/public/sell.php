<?php

    // configuration
    require("../includes/config.php"); 

    // query for all symbols and shares
    $positions = [];
    $share_sell = [];
    $rows = query("SELECT * FROM stocks WHERE id = ?", $_SESSION["id"]);
    // no stocks
    if (empty($rows))
    {
        apologize("You currently have no stocks.");
    }
    
    foreach ($rows as $row) 
    {
        $stock = lookup($row["symbol"]);
        
        if ($stock !== false)
        {
            if ($_SERVER["REQUEST_METHOD"] == "POST" && $stock["name"] === $_POST["name"])
            {
                // keep track of this stock
                $share_sell = [
                    "name" => $stock["name"],
                    "price" => $stock["price"],
                    "shares" => $row["shares"],
                    "symbol" => strtoupper ($row["symbol"])
                ];
            }
            $positions[] = [
                "name" => $stock["name"],
                "price" => $stock["price"],
                "shares" => $row["shares"],
                "symbol" => strtoupper ($row["symbol"])
            ];
        }
    }
    
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // if form was empty
        if (empty($_POST["name"]))
        {
            apologize("No company was selected.");
        }
        else if (empty($_POST["shares"]))
        {
            apologize("No shares were entered.");
        }
        
        // if numeric, int, or ALL 
        if ((is_numeric($_POST["shares"]) && fmod(floatval($_POST["shares"]), 1) == 0) || $_POST["shares"] === "ALL")
        {
            if($_POST["shares"] > 0 && $_POST["shares"] < $share_sell["shares"] )
            {
                query("UPDATE users SET cash = cash + ? WHERE id = ?", ($share_sell["price"] * $_POST["shares"]), $_SESSION["id"]);
                query("UPDATE stocks SET shares = shares - ? WHERE id = ? AND symbol = ?", 
                    $_POST["shares"], $_SESSION["id"], $share_sell["symbol"]);
                // insert into history
                query("INSERT INTO history (dateTime, buySell, symbol, shares, price, id) VALUES (CURRENT_TIMESTAMP, 'SELL', ?, ?, ?, ?)",
                    $share_sell["symbol"], $_POST["shares"], $share_sell["price"], $_SESSION["id"]);
            }
            else if($_POST["shares"] = $share_sell["shares"] || $_POST["shares"] === "ALL")
            {
                // delete both stock and shares and update cash
                query("DELETE FROM stocks WHERE id = ? AND symbol = ?", $_SESSION["id"], $share_sell["symbol"]);
                query("UPDATE users SET cash = cash + ? WHERE id = ?", ($share_sell["price"] * $share_sell["shares"]), $_SESSION["id"]);
                // insert into history
                query("INSERT INTO history (dateTime, buySell, symbol, shares, price, id) VALUES (CURRENT_TIMESTAMP, 'SELL', ?, ?, ?, ?)",
                    $share_sell["symbol"], $_POST["shares"], $share_sell["price"], $_SESSION["id"]);
            
            }
            
            // if successfull render portfolio
            redirect("/");
        }
        
        // else
        apologize("The number of shares entered was not valid.  Please use your portfolio page as a reference and try again.");
        
    }
    else
    {
        // else render form
        render("sell_form.php", ["positions" => $positions, "title" => "Sell"]);
    }

?>
