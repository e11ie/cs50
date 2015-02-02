<div>
    <table class = "table table-striped">
        <thead>
            <tr>
                <th>Date/Time</th>
                <th>Buy/Sell</th>
                <th>Symbol</th>
                <th>Name</th>
                <th>Shares</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($history as $trans): ?>

            <tr>
                <td><?= $trans["dateTime"] ?></td>
                <td><?= $trans["buySell"] ?></td>
                <td><?= $trans["symbol"] ?></td>
                <td><?= $trans["name"] ?></td>
                <td><?= $trans["shares"] ?></td>
                <td>$<?= number_format ($trans["price"], 2, '.', ',' ) ?></td>
            </tr>

            <?php endforeach ?>
        </tbody>
    </table>
</div>
