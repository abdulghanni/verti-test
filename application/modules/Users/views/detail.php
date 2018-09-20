<div class="page">
  <div class="page-content">
    <div class="panel">
      <div class="panel-heading">
        <h3 class="panel-title"><?=$data->name?></h3>
      </div>
      <div class="panel-body">
        <ul class="list-group">
          <li class="list-group-item">
            <div class="media">
              <div class="pr-0 pr-sm-20 align-self-center">
                <div class="avatar avatar-online">
                  <img src="https://www.instituteofphotography.in/wp-content/uploads/2015/05/dummy-profile-pic-300x300.jpg" alt="...">
                  <i class="avatar avatar-busy"></i>
                </div>
              </div>
              <div class="col-md-6">
                <h5 class="mt-0 mb-5">
                  <?=$data->username?>
                </h5>
                <p>
                  <i class="icon icon-color md-email" aria-hidden="true"></i><?=$data->email?>
                </p>
                <p>
                  <i class="icon icon-color md-phone" aria-hidden="true"></i><?=$data->phone?>
                </p>
                <p>
                  <i class="icon icon-color md-globe" aria-hidden="true"></i><?=$data->website?>
                </p>
                <br/>
                <h5>Company</h5>
                  <?=$data->company->name?>
                  <br/><?=$data->company->catchPhrase?>
                  <br/><?=$data->company->bs?>
              </div>
              <div class="col-md-6">
                <p>
                  <i class="icon icon-color md-pin" aria-hidden="true"></i><?=$data->address->street?>
                  <br/><?=$data->address->suite?>
                  <br/><?=$data->address->city?>
                  <br/><?=$data->address->zipcode?>
                </p>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div id="map"></div>
  </div>
</div>

<script>
      function myMap() {
    var mapOptions = {
        center: new google.maps.LatLng(51.5, -0.12),
        zoom: 10,
        mapTypeId: google.maps.MapTypeId.HYBRID
    }
var map = new google.maps.Map(document.getElementById("map"), mapOptions);
}
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?callback=myMap"></script>