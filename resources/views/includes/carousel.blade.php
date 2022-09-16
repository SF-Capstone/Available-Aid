<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

<style>
.gap{
  width:200px;
  background:none;
  height:100px;
  display:inline-block;
}

  .carousel-inner img {
    width: 100%;
    height: 100%;
  }

</style>

<div class='gap'></div>
<div id="demo" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
  </ul>
  
  <!-- The slideshow -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="images/home1.jpg" alt="home1" width="402" height="338">
      <div class="carousel-caption">
        <h3>Blanchet House</h3>
        <p>Welcome to Blanchet House!</p>
      </div>
    </div>

    <div class="carousel-item">
      <img src="images/home2.jpg" alt="home2" width="402" height="338">
      <div class="carousel-caption">
        <h3>Clark Center</h3>
        <p>Welcome to Clark Center!</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="images/home3.jpg" alt="home3" width="402" height="338">
      <div class="carousel-caption">
        <h3>Portland Rescur Mission</h3>
        <p>Welcome to Portland Rescur Mission!</p>
      </div>
    </div>
  </div>
  
  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
  <div class='gap'></div>
</div>

