<div>
    
    <p><h1>Hello <?= $_SESSION["username"] ?>!</h1></p>
        
    <p>You currently have TODOTODOTODO pet(s) posted.</p>
    <p>To view a pet you posted click on it's link below.  If you would like to edit or delete a post, 
    click on the respective icon to the right of the link you want to modify.</p>
    <?php if ($cursor === "no"): ?>
    <div class="panel panel-default text-left">
      <div class="panel-body"><h4>You have not created a poster</h4>
      </div>
    </div>
    <?php endif ?>
    <?php if ($cursor !== "no"): ?><?php foreach ($cursor as $doc): ?>
    <div>
        <?php $n = $doc["_id"] ?> 
        <div class="panel panel-default text-left">
          <div class="panel-body">
            <div class="media">
              <a class="pull-left" href="/"><img alt="C$50 Finance" src="/img/logo.gif" height="42" width="42"/></a>
              <div class="media-body text-left"><?php $reported = $doc["reported"]; ?>
                <h4 class="media-heading"><a href="poster.php?id=<?= $n ?>"><?= ucwords($doc["status"]) ?><?php if($doc["name"] !== "none given"): ?> <?= ucwords($doc["name"]) ?><?php endif ?> on <?= date('M d, Y', $reported->sec) ?> 
                at <?= $doc["lat"] ?> Latitude, <?= $doc["lng"] ?> Longitude</a></h4>
                
                Species:  <?= ucwords($doc["species"]) ?>, Breed:  <?= ucwords($doc["breed"]) ?>, Gender:  <?= ucwords($doc["gender"]) ?>, 
                Weight:  <?= $doc["weight"] ?>, Age:  <?= $doc["age"] ?>, ID Chip: <?= ucwords($doc["chip"]) ?>,  
                Primary Color:  <?= ucwords($doc["primarycolor"]) ?>, Secondary Color: <?= ucwords($doc["secondarycolor"]) ?>
                <?php $ya = $doc["_id"]; ?> <?php if ($_SESSION["username"] === $doc["username"]): ?><br>
                    <a href="edit_poster.php?id=<?= $ya ?>">Edit Poster</a>  or  
                    <a href="delete_poster.php?id=<?= $ya ?>">Delete Poster</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
    </div>
    <?php endforeach ?><?php endif ?>
    
</div>
