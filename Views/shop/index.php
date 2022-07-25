<section class="hero" data-aos="fade-zoom-in" data-aos-duration="3000" data-aos-delay="200">
    <img src=".\public\assets\pictures\kawa_img_hero_desktop.jpeg" alt="hero">
    <div class="CTA">
        <img class="logoHomePage" data-aos="fade-left" data-aos-duration="4000" src=".\public\assets\pictures\kawa_logo_blac_text.svg" alt="Kawa" />
        <h2 data-aos="fade-up" data-aos-duration="2000" data-aos-delay="1000">Une boutique dédiée aux amateurs de café</h2>
        <a  data-aos="fade-up" data-aos-duration="4000" data-aos-delay="2000" href="./boutique/all"> Découvrir</a>
    </div>
</section>
<div class="homeContainer">


    <article class="introHome">
        <section>
            <img id="fleche" src=".\public\img\icone_fleche.png" alt="icone fleche" />
            <p>
                Nos meilleurs ventes, ainsi que les nouveautés. <br> Laissez-vous guider par vos habitudes gustative.
            </p>
        </section>
    </article>


    <article class="homeProposition">
        <section class="caroussel caroussel--home">
            <div class="caroussel__element">
                <?php for ($i = 0; $i <= $selectNumberofCard; $i++) : ?>
                    <?php $cards->printCard($cards->getDataByid($bestArticle[$i]['fk_id_article'])) ?>
                <?php endfor; ?>
            </div>
        </section>

        <section class="lastProduct">
            <?php $cards->printCard($cards->getDataByid($lastidProduct)) ?>
            <img class="vignette" src=".\public\assets\pictures\kawa_icon_new.svg" alt="">
        </section>
    </article>


    <div data-aos="fade-right" data-aos-duration="3000">
        <h2 class="home_title">NOTRE PHILOSOPHIE</h2>
    </div>
    
    <article data-aos="fade-right" data-aos-duration="3000" class="introHome">
        <section>
            <img id="fleche" src=".\public\img\icone_fleche.png" alt="icone fleche" />
            <p>
                Passionnés de café, c’est après avoir réalisés plusieurs voyages aux Bresil, Hawai,
                Kenya que nous avons découvert des cafés d'exceptions.
                Devant la méconnaissance de café riche et singulier, nous avons décidé de créer Kawa afin de rendre ses grains d'exceptions accessibles.
            </p>
        </section>
    </article>

    <section>
        <div class="container_responsive">
            <div id="img2" class=" card" data-aos="fade-down" data-aos-duration="6000" data-aos-offset="0">
                <div class="imgBx">
                    <img src=".\public\assets\pictures\cafe_gout.jpeg">

                </div>
                <div class="contentBx">
                    <div class="content">
                        <h3>La passion</h3>
                        <p>De l'information pour vous transmettre le gout du café !</p>
                    </div>


                </div>
            </div>
            <div id="img1" class="card" data-aos="zoom-out" data-aos-duration="3000" data-aos-delay="5000" data-aos-offset="0">
                <div class="imgBx">
                    <img src=".\public\assets\pictures\voyage_cafe.jpeg">
                </div>
                <div class="contentBx">
                    <div class="content">
                        <h3>Voyage</h3>
                        <p>Passionnés de café, nouvelle culture, on souhaite vous faire partager notre quotidien.</p>
                    </div>
                </div>
            </div>

            <div id="img3" class="card" data-aos="fade-up" data-aos-duration="3000" data-aos-offset="0">
                <div class="imgBx">
                    <img src=".\public\assets\pictures\agriculteur_cafe.jpeg">
                </div>
                <div class="contentBx">
                    <div class="content">
                        <h3>Transparence</h3>
                        <p>Partager des cafés d'exceptions en respectant le travail de nos partenaires.</p>
                    </div>
                </div>
            </div>


        </div>
    </section>

    
    <h2 class="home_title">Comment aimez vous boire votre café ?</h2>
    <div class="scrollHorizontal">

        <article class="containerCard">


            <section class="cardChoice">
                <a href="./boutique/all?selection=1">
                    <img src="public\assets\pictures\kawa_img_card1.jpg" alt="">
                    <p>Un deca sans pression</p>
                </a>
            </section>


            <section class="cardChoice">
                <a href="./boutique/all?selection=2">
                    <img src="public\assets\pictures\kawa_img_card2.jpg" alt="">
                    <p>Noir et bien corsée</p>
                </a>
            </section>

            <section class="cardChoice">
                <a href="./boutique/Moulu">
                    <img src="public\assets\pictures\kawa_img_card3.jpg" alt="">
                    <p>Moulu à souhait</p>
                </a>
            </section>

            <section class="cardChoice">
                <a href="./boutique/Dosette">
                    <img src="public\assets\pictures\kawa_img_card4.jpg" alt="">
                    <p>La Dosette douceur du matin</p>
                </a>
            </section>

            <section class="cardChoice">
                <a href="./boutique/all?recherche=Afrique">
                    <img src="public\assets\pictures\pexels-efecan-efe-8200210.jpg" alt="">
                    <p>J'aime découvrir des nouvelles saveurs</p>
                </a>
            </section>

            <section class="cardChoice">
                <a href="./boutique/all?recherche=Biologique">
                    <img src="public\assets\pictures\kawa_img_card6.jpg" alt="">
                    <p>Un café en accord avec la nature</p>
                </a>
            </section>

            <section class="cardChoice">
                <a href="./boutique/Grain">
                    <img src="public\assets\pictures\kawa_img_card7.jpg" alt="">
                    <p>Au percolateur</p>
                </a>
            </section>

            <section class="cardChoice">
                <a href="./boutique/all?recherche=Equilibré">
                    <img src="public\assets\pictures\kawa_img_card8.jpg" alt="">
                    <p>Un café légé et équilibré</p>
                </a>
            </section>

        </article>
    </div>



</div>