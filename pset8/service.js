/**
 * service.js
 *
 * Computer Science 50
 * Problem Set 8
 *
 * Implements a shuttle service.
 */

// default height
var HEIGHT = 0.8;

// default latitude
var LATITUDE = 42.3745615030193;

// default longitude
var LONGITUDE = -71.11803936751632;

// default heading
var HEADING = 1.757197490907891;

// default number of seats
var SEATS = 10;
var ss = null;

// global regerence to default velocity
var VELOCITY = 50;

// global regerence to random passenger places
var places = [];

// global reference to shuttle's marker on 2D map
var bus = null;

// global reference to 3D Earth
var earth = null;

// global reference to 2D map
var map = null;

// global reference to shuttle
var shuttle = null;
var rotation = HEADING * 180 / Math.PI;

// load version 1 of the Google Earth API
google.load("earth", "1");

// load version 3 of the Google Maps API
google.load("maps", "3", {other_params: "sensor=false"});

// once the window has loaded
$(window).load(function() {

    // teleport menu
    teleportMenu();
    
    // listen for keydown anywhere in body
    $(document.body).keydown(function(event) {
        $("#announcements").html("No announcements at this time.");
        return keystroke(event, true);
    });

    // listen for keyup anywhere in body
    $(document.body).keyup(function(event) {
        $("#announcements").html("No announcements at this time.");
        
        return keystroke(event, false);
    });

    // listen for click on Drop Off button
    $("#dropoff").click(function(event) {
        dropoff();
    });

    // listen for click on Pick Up button
    $("#pickup").click(function(event) {
        pickup();
    });
    
    // listen for click on teleport button
    $("#teleport").click(function(event) {
        teleport();
    });
    
    // load application
    load();
    
    //WHERE DO I PUT THIS!!!????
    //bus.icon.rotation = rotation * 180 / Math.PI;
});

// unload application
$(window).unload(function() {
    unload();
});

/**
 * Renders seating chart.
 */
function chart()
{
    var html = "<ol start='0'>";
    for (var i = 0; i < shuttle.seats.length; i++)
    {
        if (shuttle.seats[i] == null)
        {
            html += "<li>Empty Seat</li>";
        }
        else
        {
            console.log(shuttle.seats[i]);
            var wordcss = shuttle.seats[i].split(" ")
            var cssHouse = wordcss[3].toLowerCase()
            html += "<li class='" + cssHouse + "'>" + shuttle.seats[i] + "</li>";
        }
    }
    html += "</ol>";
    $("#chart").html(html);
}

/**
 * Renders dropdown menu.
 */
function teleportMenu()
{
    var x = document.getElementById("teleportme");
    for (var i = 0; i < BUILDINGS.length; i++)
    {
        var option = document.createElement("option");
        option.text = BUILDINGS[i].name;
        x.add(option);
    }  
    
}

/**
 * Drops up passengers if their stop is nearby.
 */
function dropoff()
{
    // keep track
    houseCount = 
        {
            number: 0,
            seats: 0,
            passengers: 0
        };
        
    // check HOUSES for distance
    for (var house in HOUSES)
    {
        // if shuttle.seats.passenger matches houses then null and 
        var lat = HOUSES[house].lat;
        var lng = HOUSES[house].lng;
        var d = shuttle.distance(lat, lng);
        // if d > 30.0m announce not close enough
        if (d <= 30.0)
        {
            // count houses within distance
            houseCount.number++;
            
            // check for valid destination
            for (var i = 0; i < shuttle.seats.length; i++)
            {
                if (shuttle.seats[i] != null)
                {
                    // count ppl in seats
                    houseCount.seats++;
                    
                    if (shuttle.seats[i].indexOf(house) != -1)
                    {
                        //count ppl with same house
                        houseCount.passenger++;
                        //take off chart and return value to null
                        shuttle.seats[i] = null;
                        // points
                        PASSENGERS[i].done = 2;
                        // refresh chart
                        chart();
                    }
                }
            }
        }
    }
    
    // announce it
    html = "";
    if (houseCount.number == 0)
    {
        html += "No houses nearby.  "
    }
    if (houseCount.passenger == houseCount.seats)
    {
        html += "Everyone has been dropped off!"
    }
    else if (houseCount.passenger != 0)
    {
        html += houseCount.passenger + " passenger(s) dropped off."
    }
    $("#announcements").html(html);
}

/**
 * Called if Google Earth fails to load.
 */
function failureCB(errorCode) 
{
    // report error unless plugin simply isn't installed
    if (errorCode != ERR_CREATE_PLUGIN)
    {
        alert(errorCode);
    }
}

/**
 * Handler for Earth's frameend event.
 */
function frameend() 
{
    shuttle.update();
}

/**
 * Called once Google Earth has loaded.
 */
function initCB(instance) 
{
    // anouncement
    $("#announcements").html("Loading...");
    
    // retain reference to GEPlugin instance
    earth = instance;

    // specify the speed at which the camera moves
    earth.getOptions().setFlyToSpeed(100);

    // show buildings
    earth.getLayerRoot().enableLayerById(earth.LAYER_BUILDINGS, true);

    // disable terrain (so that Earth is flat)
    earth.getLayerRoot().enableLayerById(earth.LAYER_TERRAIN, false);

    // prevent mouse navigation in the plugin
    earth.getOptions().setMouseNavigationEnabled(false);

    // instantiate shuttle
    shuttle = new Shuttle({
        heading: HEADING,
        height: HEIGHT,
        latitude: LATITUDE,
        longitude: LONGITUDE,
        planet: earth,
        seats: SEATS,
        velocity: VELOCITY
    });

    // synchronize camera with Earth
    google.earth.addEventListener(earth, "frameend", frameend);

    // synchronize map with Earth
    google.earth.addEventListener(earth.getView(), "viewchange", viewchange);

    // update shuttle's camera
    shuttle.updateCamera();

    // show Earth
    earth.getWindow().setVisibility(true);

    // render seating chart
    chart();

    // populate Earth with passengers and houses
    populate();
    
    //announce DONE!
    $("#announcements").html("Done loading!");
    // move this to when keystroke is called
    $("#announcements").html("No announcements at this time.");
}

/**
 * Handles keystrokes.
 */
function keystroke(event, state)
{
    // ensure we have event
    if (!event)
    {
        event = window.event;
    }
        
    // left arrow
    if (event.keyCode == 37)
    {
        shuttle.states.turningLeftward = state;
        return false;
    }

    // up arrow
    else if (event.keyCode == 38)
    {
        shuttle.states.tiltingUpward = state;
        return false;
    }

    // right arrow
    else if (event.keyCode == 39)
    {
        shuttle.states.turningRightward = state;
        return false;
    }

    // down arrow
    else if (event.keyCode == 40)
    {
        shuttle.states.tiltingDownward = state;
        return false;
    }

    // A, a
    else if (event.keyCode == 65 || event.keyCode == 97)
    {
        shuttle.states.slidingLeftward = state;
        return false;
    }

    // D, d
    else if (event.keyCode == 68 || event.keyCode == 100)
    {
        shuttle.states.slidingRightward = state;
        return false;
    }
  
    // S, s
    else if (event.keyCode == 83 || event.keyCode == 115)
    {
        shuttle.states.movingBackward = state;     
        return false;
    }

    // W, w
    else if (event.keyCode == 87 || event.keyCode == 119)
    {
        shuttle.states.movingForward = state;    
        return false;
    }
    
    // Q, q
    else if ((event.keyCode == 81 || event.keyCode == 113) && shuttle.velocity > 5)
    {
        
        shuttle.velocity -= 10;
        return false; 
    }
    
    // E, e
    else if (event.keyCode == 69 || event.keyCode == 101)
    {
        shuttle.velocity += 10;    
        return false;
    }
  
    return true;
}

/**
 * Loads application.
 */
function load()
{
    // embed 2D map in DOM
    var latlng = new google.maps.LatLng(LATITUDE, LONGITUDE);
    map = new google.maps.Map($("#map").get(0), {
        center: latlng,
        disableDefaultUI: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: false,
        zoom: 17,
        zoomControl: true
    });
    
    // prepare shuttle's icon for map
    bus = new google.maps.Marker({
        icon: "https://maps.gstatic.com/intl/en_us/mapfiles/ms/micons/bus.png",
        map: map,
        title: "you are here"
    });
        
    // embed 3D Earth in DOM
    google.earth.createInstance("earth", initCB, failureCB);
}

/**
 * Picks up nearby passengers.
 */
function pickup()
{
    // check seating chart for how many seats we have
    // check everyone at least once and keep track
    var passengerCount = 
            {
                number: 0,
                house: 0,
                seats: 0
            };
            
    for (var i in PASSENGERS)
    {
        var lat = PASSENGERS[i].placemark.getGeometry().getLatitude();
        var lng = PASSENGERS[i].placemark.getGeometry().getLongitude();
        var d = shuttle.distance(lat, lng);
        
        // check: distance, house, seating chart
        if (d <= 15.0)
        {
            // count passengers within distance
            passengerCount.number++;
            // check for valid destination
            for (var houses in HOUSES)
            {
                if (PASSENGERS[i].house.indexOf(houses) != -1)
                {
                    // destination = true
                    passengerCount.house++;
                    for (var k = 0; k < shuttle.seats.length; k++)
                    {
                        if (shuttle.seats[k] == null && PASSENGERS[i].done == 0)
                        {
                            shuttle.seats[k] = PASSENGERS[i].name + " to " + PASSENGERS[i].house;
                            
                            cssHouse = PASSENGERS[i].house;
                            
                            // count seats taken
                            passengerCount.seats++;
                            
                            // render seating chart
                            chart();
                            
                            // clear person markers from maps
                            var features = earth.getFeatures();
                            features.removeChild(PASSENGERS[i].placemark);
                            
                            PASSENGERS[i].marker.setMap(null); 
                            // points
                            PASSENGERS[i].done = 1;
                                                        
                            { break }
                        }
                        
                    }
                }
            }
        }
        
    }
    
    // update announcements
    // if picked up
    var html = "";
    //"No passengers picked up."
    if (passengerCount.number == 0)
    {
        html += "No passengers nearby to pick up.  ";
    }
    if (passengerCount.house - passengerCount.seats != 0)
    {
        html += "There are not enough seats.  ";
    }
    if (passengerCount.seats != 0)
    {
        html += passengerCount.seats + " passenger(s) picked up.  ";
    }
    if ((passengerCount.number - passengerCount.house) != 0)
    {
        html += (passengerCount.number - passengerCount.house) + " are freshmen.  "
    }
    if (html == "")
    {
        html = "There are no announcements at this time."
    }
    
    // set announcement
    $("#announcements").html(html);
}

/**
 * Populates Earth with passengers and houses.
 */
function populate()
{
    // mark houses
    for (var house in HOUSES)
    {
        // plant house on map
        new google.maps.Marker({
            icon: "https://google-maps-icons.googlecode.com/files/home.png",
            map: map,
            position: new google.maps.LatLng(HOUSES[house].lat, HOUSES[house].lng),
            title: house
        });
    }

    // get current URL, sans any filename
    var url = window.location.href.substring(0, (window.location.href.lastIndexOf("/")) + 1);

    // scatter passengers
    for (var i = 0; i < PASSENGERS.length; i++)
    {
        // pick a random building
        var building = BUILDINGS[Math.floor(Math.random() * BUILDINGS.length)];

        // prepare placemark
        var placemark = earth.createPlacemark("");
        placemark.setName(PASSENGERS[i].name + " to " + PASSENGERS[i].house);

        // prepare icon
        var icon = earth.createIcon("");
        icon.setHref(url + "/img/" + PASSENGERS[i].username + ".jpg");

        // prepare style
        var style = earth.createStyle("");
        style.getIconStyle().setIcon(icon);
        style.getIconStyle().setScale(4.0);

        // prepare stylemap
        var styleMap = earth.createStyleMap("");
        styleMap.setNormalStyle(style);
        styleMap.setHighlightStyle(style);

        // associate stylemap with placemark
        placemark.setStyleSelector(styleMap);

        // prepare point
        var point = earth.createPoint("");
        point.setAltitudeMode(earth.ALTITUDE_RELATIVE_TO_GROUND);
        point.setLatitude(building.lat);
        point.setLongitude(building.lng);
        point.setAltitude(0.0);

        // associate placemark with point
        placemark.setGeometry(point);

        // add placemark to Earth
        earth.getFeatures().appendChild(placemark);

        // add marker to map
        var marker = new google.maps.Marker({
            icon: "https://maps.gstatic.com/intl/en_us/mapfiles/ms/micons/man.png",
            map: map,
            position: new google.maps.LatLng(building.lat, building.lng),
            title: PASSENGERS[i].name + " at " + building.name
        });

        // remember passenger's placemark and marker for pick-up's sake
        PASSENGERS[i].placemark = placemark;
        PASSENGERS[i].marker = marker;
        PASSENGERS[i].done = 0;
    }
}

/**
 * Teleports the shuttle.
 */
function teleport()
{
    // get where to teleport
    var x = document.getElementById("teleportme").value;
    // set shuttle position
    // search != -1
    for (var i = 0; i < BUILDINGS.length; i++)
    {
        var build = BUILDINGS[i].name
        if (build.indexOf(x) != -1)
        {
            
            // save people in seats
            ss = shuttle.seats
            // instantiate shuttle
            shuttle = new Shuttle({
                heading: HEADING,
                height: HEIGHT,
                latitude: BUILDINGS[i].lat,
                longitude: BUILDINGS[i].lng,
                planet: earth,
                seats: SEATS,
                velocity: VELOCITY
            });
            shuttle.seats = ss;
        }
    }
    // reset dropdown to none
    document.getElementById("teleportme").value = "none";
}

/**
 * Handler for Earth's viewchange event.
 */
function viewchange() 
{
    // keep map centered on shuttle's marker
    var latlng = new google.maps.LatLng(shuttle.position.latitude, shuttle.position.longitude);
    map.setCenter(latlng);
    bus.setPosition(latlng);
    //if (bus.rotation != (shuttle.headingAngle * 180 / Math.PI)){ console.log(shuttle.headingAngle * 180 / Math.PI);}
}

/**
 * Unloads Earth.
 */
function unload()
{
    google.earth.removeEventListener(earth.getView(), "viewchange", viewchange);
    google.earth.removeEventListener(earth, "frameend", frameend);
}
