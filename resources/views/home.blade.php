<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Test</title>
  <link href="{{ asset('css/home.css') }}" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">Test</a>
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarNav"
      aria-controls="navbarNav"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-3">
        <li class="nav-item">
          <a class="nav-link active" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Help</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">Login</a>
        </li>
     <li class="nav-item">
        <a class="btn btn-custom-quote rounded-pill px-4" href="#">Get Quote</a>
    </li>
      </ul>
    </div>
  </div>
</nav>

<section class="hero-image d-flex align-items-center justify-content-center text-center text-white">
  <div class="overlay"></div>
  <div class="content position-relative">
    <h1 class="display-4 fw-bold">Welcome test</h1>
    <p class="lead">Your satisfaction is our priority.</p>
    <a href="#" class="btn btn-custom-quote rounded-pill px-4 mt-1">Get Quote</a>
  </div>
</section>


<section class="py-5 bg-light text-center">
  <div class="container">
    <h2 class="mb-4">Our Event Services</h2>
    <div class="row g-4 justify-content-center">
      
      <div class="col-md-3">
        <div class="card h-100 shadow-sm">
          <img src="{{ asset('img/wedding.webp') }}" class="card-img-top" alt="Weddings" />
          <div class="card-body">
            <h5 class="card-title">Weddings</h5>
            <p class="card-text">Beautiful and memorable wedding event planning tailored to your dreams.</p>
          </div>
        </div>
      </div>
      
      <div class="col-md-3">
        <div class="card h-100 shadow-sm">
          <img src="{{ asset('img/birthday.jpg') }}" class="card-img-top" alt="Birthdays" />
          <div class="card-body">
            <h5 class="card-title">Birthdays</h5>
            <p class="card-text">Fun and exciting birthday celebrations customized for all ages.</p>
          </div>
        </div>
      </div>
      
      <div class="col-md-3">
        <div class="card h-100 shadow-sm">
          <img src="{{ asset('img/debut.webp') }}" class="card-img-top" alt="Debuts" />
          <div class="card-body">
            <h5 class="card-title">Debuts</h5>
            <p class="card-text">Elegant debut parties that mark this special milestone with style.</p>
          </div>
        </div>
      </div>
      
      <div class="col-md-3">
        <div class="card h-100 shadow-sm">
          <img src="{{ asset('img/baptism.jpg') }}" class="card-img-top" alt="Baptisms" />
          <div class="card-body">
            <h5 class="card-title">Baptisms</h5>
            <p class="card-text">Graceful baptism events that celebrate faith and family.</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>



<section class="py-5 text-center">
  <div class="container">
    <h2 class="mb-3">Who We Are</h2>
    <p class="lead">We’re passionate about delivering the best service to our customers with honesty and integrity.</p>
  </div>
</section>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
