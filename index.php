<!DOCTYPE html>
<html lang="en">

<?php include("./components/head.html"); ?>

<body>

<?php include("./components/navbar.html"); ?>
  
<?php include("./components/filtro.html"); ?>

<div id="container">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide" data-index="0" data-category="macho">
                <div class="slide-content">
                    <h2 class="title">Cachorro</h2>
                    <div class="caption">Porte grande</div>
                    <img src="img/cachorro7.jpg" alt="Imagem de um cachorro">
                </div>
            </div>

            <?php
            include_once("./services/conexao.php");

            $sql = "SELECT * FROM cachorros;";
            $result = mysqli_query($conn, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="swiper-slide" data-index="' . $row['id'] . '" data-category="cachorro">
                        <div class="slide-content">
                            <h2 class="title">' . $row['nome'] . '</h2>
                            <div class="caption">' . $row['porte'] . '</div>
                            <img src="./uploads/' . $row['foto'] . '.jpeg" alt="Imagem de um cachorro">
                        </div>
                      </div>';
            }
            ?>
        </div>

        <div class="swiper-pagination"></div>

        <div class="button-container">
            <div class="action-buttons">
                <button id="discard-button">Próximo</button>
                <button id="like-button" onclick="window.location.href='formulario.php';">Tenho interesse</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const swiper = new Swiper('.swiper-container', {
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            loop: true,
        });

        const discardButton = document.getElementById("discard-button");
        discardButton.addEventListener("click", () => {
            swiper.slideNext();  
        });

        const categoryFilter = document.getElementById('category-filter');
        if (categoryFilter) {
            categoryFilter.addEventListener('change', (event) => {
                const category = event.target.value;
                filterSlides(category);
            });
        }

        function filterSlides(category) {
            const slides = document.querySelectorAll('.swiper-slide');
            slides.forEach(slide => {
                if (category === 'all' || slide.getAttribute('data-category') === category) {
                    slide.style.display = ''; 
                } else {
                    slide.style.display = 'none'; 
                }
            });
            swiper.update(); 
        }
    });
</script>

</body>
</html>
