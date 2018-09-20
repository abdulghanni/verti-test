<div class="page">
  <div class="page-content">
    <div class="panel">
      <div class="panel-body">
          <h4>All Users</h4>
      </div>
    </div>
    <?php foreach ($data as $key => $r) {?>
    <div class="panel">
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
                  <?=$r->name?>
                </h5>
                <h5 class="mt-0 mb-5">
                  <a href="<?=base_url()?>/users/detail/<?=$r->id?>"><?=$r->username?></a>
                </h5>
                <p>
                  <i class="icon icon-color md-email" aria-hidden="true"></i><?=$r->email?>
                </p>
                <p>
                  <i class="icon icon-color md-phone" aria-hidden="true"></i><?=$r->phone?>
                </p>
              </div>
              <div class="col-md-6">
                <p>
                  <i class="icon icon-color md-pin" aria-hidden="true"></i><?=$r->address->street?>
                  <br/><?=$r->address->suite?>
                  <br/><?=$r->address->city?>
                  <br/><?=$r->address->zipcode?>
                </p>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  <?php } ?>
  </div>
</div>