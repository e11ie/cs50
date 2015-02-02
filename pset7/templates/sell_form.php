<form action="sell.php" method="post">
    <fieldset>
        <div class="form-group">I want to sell 
            <input autofocus class="form-control" name="shares" placeholder="Shares" type="text"/> from 
            <select class="form-control" name="name">
                <option value>Company</option>
                <?php foreach ($positions as $position): ?>
                
                <option value="<?= $position["name"] ?>"><?= $position["symbol"] ?>, <?= $position["name"] ?></option>
                
                <?php endforeach ?>
            </select>
            <br>(if you wish to sell all your shares from a certain company, simply type "ALL" into the text box)
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-default">Sell</button>
        </div>
    </fieldset>
</form>
