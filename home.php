<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jimbo Kuu la Dar-es-Salaam</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fffbf2;
            /* Pale yellow background */
        }

        header {
            background-color: #f8d400;
            /* Yellow header background */
            color: #333;
            padding: 10px;
            text-align: center;
            position: relative;
        }

        .church-icons {
            font-size: 4.5em;
            /* Increased font size for the icons */
            color: #333;
            /* Dark color for icons */
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        .church-icons.left {
            left: 10px;
        }

        .church-icons.right {
            right: 10px;
        }

        nav {
            background-color: #f8f9fa;
            padding: 10px 0;
            text-align: center;
        }

        nav a {
            color: #007bff;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }

        .slideshow-container {
            max-width: 1000px;
            margin: auto;
            text-align: center;
        }

        .mySlides {
            display: none;
        }

        img {
            width: 100%;
            height: auto;
        }

        footer {
            background-color: #f8d400;
            /* Yellow footer background */
            color: #333;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>
    <header>
        <div class="church-icons left">
            <i class="fas fa-church"></i>
        </div>
        <h1 style="font-family: 'Arial', sans-serif; font-weight: bold;">Jimbo Kuu la Dar-es-Salaam</h1>
        <div class="church-icons right">
            <i class="fas fa-church"></i>
        </div>
        <h3>Parokia ya Mtakatifu Maxmillian Maria Kolbe.</h3>
    </header>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="mx-auto">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="./home.php">Nyumbani</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./admin/add_member.php">Sajili Mtoa Zaka</a>
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
            <img src="../assets/image11.jpg" alt="Slide 1">
        </div>
        <div class="mySlides">
            <img src="./image1.jpg" alt="Slide 2">
        </div>
    </div>

    <footer>
        <p>&copy; 2023 Jimbo Kuu la Dar-es-Salaam</p>
    </footer>


    <!--JavaScript for image slideshow-->
    <script>
        var slideIndex = 0;

        function showSlides() {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1
            }
            slides[slideIndex - 1].style.display = "block";
            setTimeout(showSlides, 2000);
        }
        showSlides();
    </script>

</body>

</html>