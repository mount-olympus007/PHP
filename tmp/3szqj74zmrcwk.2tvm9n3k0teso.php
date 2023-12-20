<?php echo $this->render('./header.php',NULL,get_defined_vars(),0); ?>

  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         <div id="map" style="height: 400px; width: 100%;">

         </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Understood</button>
        </div>
      </div>
    </div>
  </div>
<div class="container">
    <div class="card" style="">
        <img src="/flexapp/Content/logoPlaceholder.jpg" class="card-img-top" alt="...">
        Work Opportunities 
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                        type="button" role="tab" aria-controls="home" aria-selected="true">Current Work</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                        type="button" role="tab" aria-controls="profile" aria-selected="false">Pending</button>
                </li>

            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <div class="col-md-6">
                            FB Flurry
                            123 Warehouse Rd
                            Dallas, TX 75222
                            Type - General Laborer
                            Rate - $12.00/hr
                            Start Time - 8:00 am
                            End Time - 4:00pm
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="initMap()">Directions</button>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            FB Flurry
                            123 Warehouse Rd
                            Dallas, TX 75222
                            Type - General Laborer
                            Rate - $12.00/hr
                            Start Time - 8:00 am
                            End Time - 4:00pm
                        </div>
                        <div class="col-md-6">
                            <button>Directions</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            FB Flurry
                            123 Warehouse Rd
                            Dallas, TX 75222
                            Type - General Laborer
                            Rate - $12.00/hr
                            Start Time - 8:00 am
                            End Time - 4:00pm
                        </div>
                        <div class="col-md-6">
                            <button>Directions</button>

                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="row">
                        <div class="col-md-6">
                            FB Flurry
                            123 Warehouse Rd
                            Dallas, TX 75222
                            Type - General Laborer
                            Rate - $12.00/hr
                            Start Time - 8:00 am
                            End Time - 4:00pm
                        </div>
                        <div class="col-md-6">
                            <button>Directions</button>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            FB Flurry
                            123 Warehouse Rd
                            Dallas, TX 75222
                            Type - General Laborer
                            Rate - $12.00/hr
                            Start Time - 8:00 am
                            End Time - 4:00pm
                        </div>
                        <div class="col-md-6">
                            <button>Directions</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            FB Flurry
                            123 Warehouse Rd
                            Dallas, TX 75222
                            Type - General Laborer
                            Rate - $12.00/hr
                            Start Time - 8:00 am
                            End Time - 4:00pm
                        </div>
                        <div class="col-md-6">
                            <button>Directions</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB_BB64Wjfvhzs3vDnEFrKRIo7sDa2Fowg&libraries=places" type="text/javascript"></script>

<script>
    function initMap(){
        var map;
            var zoomLevel = 4;
            var bounds = new google.maps.LatLngBounds();
            var infoWindow = new google.maps.InfoWindow();

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
                function showPosition(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    const geocoder = new google.maps.Geocoder();
                    const latlng = { lat: parseFloat(lat), lng: parseFloat(lng) };
                    var myPosition = new google.maps.Marker({
                        position: latlng,
                        map: map,
                        title: 'You are here!'
                    });
                    //shows position on the map
                    infoWindow.setContent('You are here!');
                            infoWindow.open(map, myPosition);
                    
                }
            }

            var mapOptions = {
                    zoom: zoomLevel,
                    disableDefaultUI: false,
                    center: new google.maps.LatLng(44.967243, -103.77155), // New York
                    // Map styling
                    styles: [{
                        featureType: 'water',
                        elementType: 'all',
                        stylers: [{
                            hue: '#e9ebed'
                        }, {
                            saturation: -78
                        }, {
                            lightness: 67
                        }, {
                            visibility: 'simplified'
                        }]
                    }, {
                        featureType: 'landscape',
                        elementType: 'all',
                        stylers: [{
                            hue: '#ffffff'
                        }, {
                            saturation: -100
                        }, {
                            lightness: 100
                        }, {
                            visibility: 'simplified'
                        }]
                    }, {
                        featureType: 'road',
                        elementType: 'geometry',
                        stylers: [{
                            hue: '#bbc0c4'
                        }, {
                            saturation: -93
                        }, {
                            lightness: 31
                        }, {
                            visibility: 'simplified'
                        }]
                    }, {
                        featureType: 'poi',
                        elementType: 'all',
                        stylers: [{
                            hue: '#ffffff'
                        }, {
                            saturation: -100
                        }, {
                            lightness: 100
                        }, {
                            visibility: 'off'
                        }]
                    }, {
                        featureType: 'road.local',
                        elementType: 'geometry',
                        stylers: [{
                            hue: '#e9ebed'
                        }, {
                            saturation: -90
                        }, {
                            lightness: -8
                        }, {
                            visibility: 'simplified'
                        }]
                    }, {
                        featureType: 'transit',
                        elementType: 'all',
                        stylers: [{
                            hue: '#e9ebed'
                        }, {
                            saturation: 10
                        }, {
                            lightness: 69
                        }, {
                            visibility: 'on'
                        }]
                    }, {
                        featureType: 'administrative.locality',
                        elementType: 'all',
                        stylers: [{
                            hue: '#2c2e33'
                        }, {
                            saturation: 7
                        }, {
                            lightness: 19
                        }, {
                            visibility: 'on'
                        }]
                    }, {
                        featureType: 'road',
                        elementType: 'labels',
                        stylers: [{
                            hue: '#bbc0c4'
                        }, {
                            saturation: -93
                        }, {
                            lightness: 31
                        }, {
                            visibility: 'on'
                        }]
                    }, {
                        featureType: 'road.arterial',
                        elementType: 'labels',
                        stylers: [{
                            hue: '#bbc0c4'
                        }, {
                            saturation: -93
                        }, {
                            lightness: -2
                        }, {
                            visibility: 'simplified'
                        }]
                    }]
                };
                var mapElement = document.getElementById('map');
                map = new google.maps.Map(mapElement, mapOptions);              
                map.setCenter(new google.maps.LatLng(44.967243, -103.77155));

    }
</script>
<?php echo $this->render('./footer.php',NULL,get_defined_vars(),0); ?>