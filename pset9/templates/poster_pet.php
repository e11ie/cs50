<div>
<?php $reported = $cursor["reported"]; ?>
    <h3><?= ucwords($cursor["status"]) ?><?php if($cursor["name"] !== "none given"): ?> <?= ucwords($cursor["name"]) ?><?php endif; ?> on <?= date('M d, Y', $reported->sec) ?></h3>
    <p><img alt="image path here" src="/img/alternate.png" height="240" width="240"/></p>
    <p></p>
    <h4>General Characterization</h4>
    <p>Species:  <?= ucwords($cursor["species"]) ?><br>Breed:  <?= ucwords($cursor["breed"]) ?><br>Weight:  <?= $cursor["weight"] ?><br>
    Gender:  <?= ucwords($cursor["gender"]) ?><br>Age:  <?= $cursor["age"] ?><br>ID Chip: <?= ucwords($cursor["chip"]) ?>, 
    <?php if($cursor["chip"] === "yes"): ?>  <?= $cursor["id"] ?> <?php endif; ?></p>
    <p></p>
    <h4>Description</h4>
    <p>Primary Color:  <?= ucwords($cursor["primarycolor"]) ?><br>Secondary Color: <?= ucwords($cursor["secondarycolor"]) ?><br>
    Other Description:  <?= $cursor["description"] ?></p>
    <p></p>
    <p></p>
    <h4>Contact Me Please!</h4>
    <p>Phone:  <?= $cursor["phone"] ?><br>Email:  <?= $cursor["email"] ?></p> <p></p><p></p>
    <?php $posted = $cursor["posted"]; ?>
    <p class="small">This was posted on <?= date('Y-M-d h:i:s', $posted->sec) ?> by <?= $cursor["username"] ?></p>
    <?php $ya = $cursor["_id"]; ?> <?php if (!empty($_SESSION["username"]) && $_SESSION["username"] === $cursor["username"]): ?>
        <a href="edit_poster.php?id=<?= $ya ?>">Edit Poster</a>  or  
        <a href="delete_poster.php?id=<?= $ya ?>">Delete Poster</a>
    <?php endif; ?>
</div>
