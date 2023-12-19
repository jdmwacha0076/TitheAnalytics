<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mfumo wa Taarifa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="./assets/logo2.png" rel="icon">
    <link rel="stylesheet" href="./assets/styles.css">
</head>

<body>
    <header>
        <div class="church-icons left">
            <i class="fas fa-church"></i>
        </div>
        <h1 style="font-family: 'Arial', sans-serif; font-weight: bold;"> Jimbo Kuu la (Jina la Jimbo)</h1>
        <div class="church-icons right">
            <img src="./assets/tithecollect.png" alt="Slide 1" class="custom-image">
        </div>
        <h3> Parokia ya (Sehemu ya Jina la Parokia) </h3>
    </header>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="mx-auto">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="./home.php">Nyumbani</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./admin/add_member.php">Sajili Mtoa Zaka </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./admin/view_members.php">Tizama Watoa Zaka</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./admin/record_tithe.php">Rekodi Zaka</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./admin/send_message.php">Tuma Jumbe za Zaka</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="slideshow-container">

        <div class="mySlides">
            <div class="image-overlay">
                <h2>"Mheshimu Bwana kwa mali yako, na kwa malimbuko ya mazao yako yote.
                     Ndipo ghala zako zitakapojazwa kwa wingi, na mashinikizo yako yatafurika 
                     divai mpya. Mwanangu, usidharau maonyo ya Bwana, wala usichukizwe na adhabu yake. 
                     Kwa maana Bwana ampendaye humrekebisha, kama vile baba ampendaye mwana wake. 
                     Heri mtu yule apataye hekima, na mtu yule apataye ufahamu." Mithali 3:9-13</h2>
            </div>
            <img src="./assets/slide3.jpg" alt="Slide 1">
        </div>

        <div class="mySlides">
            <div class="image-overlay">
                <h2>"Mlete mzima zaka ghalani, ili kuwapo chakula katika nyumba yangu;
                     jipimeni sasa kwa hayo, asema Bwana wa majeshi, mimi sitawafungulia
                      ninyi madirisha ya mbinguni, wala sitawamwagieni baraka, hata isiwepo 
                      nafasi ya kutosha ya kuziweka. Nami nitamkemea yule mla nyama kwa ajili 
                      yenu, wala hataharibu mazao ya ardhi yenu; wala mzabibu wenu hautaachwa
                       kuzaa matunda yake kabla ya wakati wake, asema Bwana wa majeshi." Malaki 3:10-12 </h2>
            </div>
            <img src="./assets/slide1.jpg" alt="Slide 2">
        </div>
    </div>

    <!-- <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="alert alert-info info">
                    <div class="info-body">
                        <h5 class="info-title">Getting Started</h5>
                        <p class="info-text">Follow these steps to get started with the system.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="alert alert-info info">
                    <div class="info-body">
                        <h5 class="info-title">Data Entry</h5>
                        <p class="info-text">Learn how to enter and manage data in the system.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="alert alert-info info">
                    <div class="info-body">
                        <h5 class="info-title">Reports and Analytics</h5>
                        <p class="info-text">Explore the reporting features and analytics tools available.</p>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <?php include 'footer.php'; ?>

</body>

</html>

<!--JavaScript for image slideshow-->
<script>
    var slideIndex = 1;
    showSlides(slideIndex);

    // Set interval to change slides every 2 seconds
    setInterval(function() {
        plusSlides(1);
    }, 2000);

    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");

        if (n > slides.length) {
            slideIndex = 1;
        }

        if (n < 1) {
            slideIndex = slides.length;
        }

        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }

        slides[slideIndex - 1].style.display = "block";
    }
</script>