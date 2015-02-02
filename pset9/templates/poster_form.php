<form action="new_poster.php" method="post">
    <fieldset>
        
        <input type="hidden" name="petid" value="none">
        <h3><?= $title ?></h3><br>
        <h4>Basic Information</h4>
        <p>Note: required fields have an (*) by them!</p>
        <div class="form-group">
            <select name="status">
		        <option value="found">Found</option>
		        <option value="lost" selected>Lost</option>
	        </select>*
        </div>
        <div class="form-group">Date Lost/Found*:  
            <input class="form-control" name="reported" type="date"/>
        </div>
        Where did you lose/find your pet?<br>
        (hint: go to http://www.latlong.net/ to find a latitude and longitude from an address)
        <div class="form-group">
            Latitude*:  <input class="form-control" name="lat" placeholder="Latitude" type="text"/>
        </div>
        <div class="form-group">
            Longitude*:  <input class="form-control" name="lng" placeholder="Longitude" type="text"/>
        </div>
        <div class="form-group">
            Pet Name:  <input class="form-control" name="name" placeholder="petname" type="text" maxlength="65"/>
        </div>

        <h4>General Physical Characterization</h4>
        <div class="form-group">Species*:  
            <select name="species">
		        <option value="other">Other</option>
		        <option value="dog" selected>Dog</option>
		        <option value="cat">Cat</option>
	        </select>
        </div>
        <div class="form-group">
            Breed (Leave this blank if you don't know!):  <input class="form-control" name="breed" placeholder="Breed" type="text"/>
        </div>
        <div class="form-group">
                Gender<span class="error">*</span>:  
                <input type="radio" name="gender" value="male">Male     
	            <input type="radio" name="gender" value="female">Female
        </div>
        <div class="form-group">
            Weight*:  <input class="form-control" name="weight" placeholder="weight (in lbs)" type="text" maxlength="65"/>
        </div>
        <div class="form-group">
            Age:  <input class="form-control" name="age" placeholder="age aprox" type="text" maxlength="65"/>
        </div>
        <div class="form-group">
            ID chip*:  
            <select name="chip">
		        <option value="no" selected>No</option>
		        <option value="yes">Yes</option>
	        </select> <br>
            If yes:  <input class="form-control" name="id" placeholder="ID Chip #" type="text" maxlength="40"/>
        </div>

        <h4>Color Description</h4>
        <div class="form-group">
            Primary Color*:  <input class="form-control" name="primarycolor" placeholder="primary color" type="text" maxlength="65"/>
        </div>
        <div class="form-group">
            Secondary Color:  <input class="form-control" name="secondarycolor" placeholder="secondary color" type="text" maxlength="65"/>
        </div>
        <div class="form-group">
	        <textarea name="description" placeholder="Description (optional)" rows="10" cols="30" maxlength="500"></textarea>
        </div>
        
        <h4>Contact info</h4>
        <div class="form-group">
            Phone Number:  <input class="form-control" name="phone" placeholder="phone number" type="text" maxlength="10"/>
        </div>
        <div class="form-group">
            Email*:  <input class="form-control" name="email" placeholder="email" type="email"/>
        </div>
        <div class="form-group">
            Confirm your email*:  <input class="form-control" name="confirm" placeholder="comfirm email" type="email"/>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-default">GO</button>
        </div>
        
    </fieldset>
</form>
