<form action="search.php" method="post">
    <fieldset>
        <h4>Search</h4>
        <p>Fill out all or only one of the following.  If you don't want to narrow the search down further, please leave the other fields blank.</p>
        <div class="form-group">
            <input class="form-control" name="search" placeholder="Search..." type="text" maxlength="150"/>
            <select name="field">
                <option value="field_none" selected>None</option>
                <option value="username">Username</option>
                <option value="name">Pet Name</option>
                <option value="breed">Breed</option>
                <option value="age">Age</option>
                <option value="weight">Weight</option>
                <option value="primarycolor">Primary Color</option>
                <option value="secondarycolor">Secondary Color</option>
                <option value="description">Description</option>
            </select>
        </div>
        <div class="form-group">And/or<br>
                Species:
            <select name="species">
                <option value="species_none" selected>none</option>
		        <option value="other">Other</option>
		        <option value="dog">Dog</option>
		        <option value="cat">Cat</option>
	        </select>
        </div>
        <div class="form-group">And/or<br>
                Gender:  
            <select name="gender">
                <option value="gender_none" selected>none</option>
		        <option value="male">Male</option>
		        <option value="female">Female</option>
            </select>
        </div>
        <div class="form-group">And/or<br>
            Latitude:  <input class="form-control" name="lat" placeholder="Latitude" type="text"/>
            Longitude:  <input class="form-control" name="lng" placeholder="Longitude" type="text"/>
        </div>
        <div class="form-group">And/or<br>
            Reported lost/found before: <input class="form-control" name="reportedbefore" type="date"/>
            Reported lost/found after: <input class="form-control" name="reportedafter" type="date"/>
        </div>
        <div class="form-group">
            <input type="submit" name="foo" value="Search" />
        </div>
    </fieldset>
</form>
