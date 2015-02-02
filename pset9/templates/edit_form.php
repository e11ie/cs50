<form action="new_poster.php" method="post">
    <fieldset><?php $petid = $cursor["_id"]; ?>
        <input type="hidden" name="petid" value="<?= $petid ?>">
        <h3>Edit Poster</h3><br><h4>Basic Information<br><?= $petid ?></h4>
        <p>Note: required fields have an (*) by them <br>
        and if you chance the name, there will be a new poster (not an edited version of the old one)</p>
        <div class="form-group">
            <select name="status">
		        <option value="found"<?php if ($cursor["status"] === "found"): ?> selected<?php endif; ?>>Found</option>
		        <option value="lost"<?php if ($cursor["status"] === "lost"): ?> selected<?php endif; ?> >Lost</option>
	        </select>*
        </div>
        <div class="form-group">Date Lost/Found*:  <?php $reported = $cursor["reported"]; ?>
            <input class="form-control" name="reported" type="date" value="<?= date('Y-m-d', $reported->sec) ?>"/>
        </div>
        Where did you lose/find your pet?<br>
        (hint: go to http://www.latlong.net/ to find a latitude and longitude from an address)
        <div class="form-group"><?php $lat = $cursor["lat"]; ?>
            Latitude*:  <input class="form-control" name="lat" value="<?= $lat ?>" type="text"/>
        </div>
        <div class="form-group"><?php $lng = $cursor["lng"]; ?>
            Longitude*:  <input class="form-control" name="lng" value="<?= $lng ?>" type="text"/>
        </div>
        <div class="form-group"><?php $name = $cursor["name"]; ?>
            Pet Name:  <input class="form-control" name="name" value="<?= $name ?>" type="text" maxlength="65"/>
        </div>

        <h4>General Physical Characterization</h4>
        <div class="form-group">Species*:  
            <select name="species">
		        <option value="other"<?php if ($cursor["species"] === "other"): ?> selected<?php endif; ?>>Other</option>
		        <option value="dog"<?php if ($cursor["species"] === "dog"): ?> selected<?php endif; ?>>Dog</option>
		        <option value="cat"<?php if ($cursor["species"] === "cat"): ?> selected<?php endif; ?>>Cat</option>
	        </select>
        </div>
        <div class="form-group"><?php $breed = $cursor["breed"]; ?>
            Breed (Leave this blank if you don't know!):  <input class="form-control" name="breed" value="<?= $breed ?>" type="text"/>
        </div>
        <div class="form-group">
            Gender<span class="error">*</span>:  
            <select name="gender">
                <option value="male"<?php if ($cursor["gender"] === "male"): ?> selected<?php endif; ?>>Male</option>
		        <option value="female"<?php if ($cursor["gender"] === "female"): ?> selected<?php endif; ?>>Female</option>
	        </select>
        </div><?= $cursor["gender"] ?>
        <div class="form-group"><?php $weight = $cursor["weight"]; ?>
            Weight*:  <input class="form-control" name="weight" value="<?= $weight ?>" type="text" maxlength="65"/>
        </div>
        <div class="form-group"><?php $age = $cursor["age"]; ?>
            Age:  <input class="form-control" name="age" value="<?= $age ?>" type="text" maxlength="65"/>
        </div>
        <div class="form-group">
            ID chip*:  
            <select name="chip">
		        <option value="no"<?php if ($cursor["chip"] === "no"): ?> selected<?php endif; ?>>No</option>
		        <option value="yes"<?php if ($cursor["chip"] === "yes"): ?> selected<?php endif; ?>>Yes</option>
	        </select> <br><?php $id = $cursor["id"]; ?>
            If yes:  <input class="form-control" name="id" value="<?= $id ?>" type="text" maxlength="40"/>
        </div>

        <h4>Color Description</h4>
        <div class="form-group"><?php $pcolor = $cursor["primarycolor"]; ?>
            Primary Color*:  <input class="form-control" name="primarycolor" value="<?= $pcolor ?>" type="text" maxlength="65"/>
        </div>
        <div class="form-group"><?php $scolor = $cursor["secondarycolor"]; ?>
            Secondary Color:  <input class="form-control" name="secondarycolor" value="<?= $scolor ?>" type="text" maxlength="65"/>
        </div>
        <div class="form-group"><?php $description = $cursor["description"]; ?>
	        <textarea name="description" value="<?= $description ?>" rows="10" cols="30" maxlength="500"></textarea>
        </div>
        
        <h4>Contact info</h4>
        <div class="form-group"><?php $phone = $cursor["phone"]; ?><?php if ($cursor["phone"] === "none given"): ?><?php $phone = ""; ?><?php endif; ?>
            Phone Number:  <input class="form-control" name="phone" value="<?= $phone ?>" type="text" maxlength="10"/>
        </div>
        <div class="form-group"><?php $email = $cursor["email"]; ?>
            Email*:  <input class="form-control" name="email" value="<?= $email ?>" type="email"/>
        </div>
        <div class="form-group">
            Confirm your email*:  <input class="form-control" name="confirm" value="<?= $email ?>" type="email"/>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-default">Submit Changes</button>
        </div>
        
    </fieldset>
</form>
