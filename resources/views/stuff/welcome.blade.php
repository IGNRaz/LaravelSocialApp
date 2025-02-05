<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="">
  </head>
  <body>

    <header>
      <a href="https://github.com/IGNRaz" class="brand">on test</a>
      <div class="menu-btn"></div>
      <div class="navigation">
        <div class="navigation-items">
          <a href="{{ route('login') }}">Login</a>
          <a href="{{ route('register') }}">Register</a>
          
        </div>
      </div>
    </header>

    <section class="home">
      <video class="video-slide active" src="../assets/img/1.mp4" autoplay muted loop></video>
      <video class="video-slide" src="../assets/img/2.mp4" autoplay muted loop></video>
      <video class="video-slide" src="../assets/img/3.mp4" autoplay muted loop></video>
      <video class="video-slide" src="../assets/img/4.mp4" autoplay muted loop></video>
      <video class="video-slide" src="../assets/img/5.mp4" autoplay muted loop></video>
      
      <div class="media-icons">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
      </div>
      <div class="slider-navigation">
        <div class="nav-btn active"></div>
        <div class="nav-btn"></div>
        <div class="nav-btn"></div>
        <div class="nav-btn"></div>
        <div class="nav-btn"></div>
      </div>
    </section>

    <script type="text/javascript">
    //Javacript for responsive navigation menu
    const menuBtn = document.querySelector(".menu-btn");
    const navigation = document.querySelector(".navigation");

    menuBtn.addEventListener("click", () => {
      menuBtn.classList.toggle("active");
      navigation.classList.toggle("active");
    });

    //Javacript for video slider navigation
    const btns = document.querySelectorAll(".nav-btn");
    const slides = document.querySelectorAll(".video-slide");
    const contents = document.querySelectorAll(".content");

    var sliderNav = function(manual){
      btns.forEach((btn) => {
        btn.classList.remove("active");
      });

      slides.forEach((slide) => {
        slide.classList.remove("active");
      });

      contents.forEach((content) => {
        content.classList.remove("active");
      });

      btns[manual].classList.add("active");
      slides[manual].classList.add("active");
      contents[manual].classList.add("active");
    }

    btns.forEach((btn, i) => {
      btn.addEventListener("click", () => {
        sliderNav(i);
      });
    });
    </script>

  </body>
</html>