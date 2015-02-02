<div class="panel panel-default text-center">
      <div class="panel-body">
<form action="poster_links.php" method="post">
    <fieldset>
        <div class="form-group"><b>Filters:  </b>
            <select name="field">
                    <option value="field_none" selected>Field</option>
                    <option value="username">Username</option>
                    <option value="name">Pet Name</option>
                    <option value="breed">Breed</option>
                    <option value="species">Species</option>
                    <option value="age">Age</option>
                    <option value="weight">Weight</option>
                    <option value="primarycolor">Primary Color</option>
                    <option value="secondarycolor">Secondary Color</option>
                    <option value="posted">Date Posted</option>
                    <option value="reported">Date Reported</option>
                    <option value="lat">Latitude</option>
                    <option value="lng">Longitude</option>
            </select>
            by 
            <select name="ascdesc">
                    <option value="ascdesc_none" selected>Asc/Desc Order</option>
                    <option value="asc">Ascending</option>
                    <option value="desc">Descending</option>
            </select>  AND/OR  View Only: 
            <select name="species">
                    <option value="species_none" selected>Species</option>
                    <option value="other">Other</option>
		            <option value="dog">Dog</option>
		            <option value="cat">Cat</option>
            </select>
            <select name="gender">
                    <option value="gender_none" selected>Gender</option>
                    <option value="male">Male</option>
		            <option value="female">Female</option>
            </select>
            <input type="hidden" name="lala" value="<?= $status ?>"/>
            <input type="submit" name="filter" value="Filter"/>
        </div>
    </fieldset>
</form>
</div>
</div>
<br>
<h4><?= $title ?></h4>
<br>
<?php foreach ($cursor as $doc): ?>
<div>
    <?php $n = $doc["_id"]; ?> <?php $reported = $doc["reported"]; ?>
    <div class="panel panel-default text-left">
      <div class="panel-body">
        <div class="media">
          <a class="pull-left" href="/"><img alt="image path here" src="/img/alternate.png" height="42" width="42"/></a>
          <div class="media-body text-left">
            <h4 class="media-heading"><a href="poster.php?id=<?= $n ?>"><?= ucwords($doc["status"]) ?><?php if($doc["name"] !== "none given"): ?> <?= ucwords($doc["name"]) ?>
                <?php endif ?> on <?= date('M d, Y', $reported->sec) ?> 
            at <?= $doc["lat"] ?> Latitude, <?= $doc["lng"] ?> Longitude</a></h4>
            Species:  <?= ucwords($doc["species"]) ?>, Breed:  <?= ucwords($doc["breed"]) ?>, Gender:  <?= ucwords($doc["gender"]) ?>, 
            Weight:  <?= $doc["weight"] ?>, Age:  <?= $doc["age"] ?>, ID Chip: <?= ucwords($doc["chip"]) ?>,  
            Primary Color:  <?= ucwords($doc["primarycolor"]) ?>, Secondary Color: <?= ucwords($doc["secondarycolor"]) ?>
          </div>
        </div>
      </div>
    </div>
</div>
<?php endforeach ?>
