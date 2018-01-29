<div id="carousel-home" data-ride="carousel" class="carousel slide carousel-fullscreen carousel-fade">
    <!-- Indicators-->
    <ol class="carousel-indicators">
        <li data-target="#carousel-home" data-slide-to="0" class="active"></li>
        <li data-target="#carousel-home" data-slide-to="1"></li>
        <li data-target="#carousel-home" data-slide-to="2"></li>
    </ol>
    <!-- Wrapper for slides-->
    <div role="listbox" class="carousel-inner">
        <div style="background-image: url('img/carousel/1.jpg');" class="item active">
            <div class="overlay"></div>
            <div class="carousel-caption">
                <h1 class="super-heading">SUNSET TRAVEL</h1>
                <p class="super-paragraph">Cestujte kdy chcete a kam chcete</a>
                </p>
            </div>
        </div>
        <div style="background-image: url('img/carousel/2.jpg');" class="item">
            <div class="overlay"></div>
            <div class="carousel-caption">
                <h1 class="super-heading">Poznejte kulturu za hranicemi</h1>
            </div>
        </div>
        <div style="background-image: url('img/carousel/3.jpg');" class="item">
            <div class="overlay"></div>
            <div class="carousel-caption">
                <h1 class="super-heading">A nebo se jen válejte na pláži...</h1>
            </div>
        </div>
    </div>
</div>
<section class="background-gray-lightest negative-margin">
    <div class="container">
        <h2>SUNSET TRAVEL</h2>
        <p class="lead">...není obyčejná cestovní kancelář.
            Máme originální techniky, díky kterým vám můžeme zprostředkovat tu nejlepší dovolenou,
            kterou jste kdy zažili. Nevěříte? Přesvědčte se sami! </p>
        <p><a href="?page=onas" class="btn btn-ghost">Číst dále...</a></p>
    </div>
</section>
<section class="section--padding-bottom-small">
    <div class="container">
        <h1> Nejlépe hodnocené destinace...</h1>
        <div class="row">
            <?php
            $stmt = $conn->prepare("SELECT * FROM hotels_w_rating ORDER BY hodnoceni DESC LIMIT 5");
            $stmt->execute();
            for ($i = 0; $i < 2; $i++) {
                $result = $stmt->fetch(PDO::FETCH_BOTH);
                echo "
                    <div class='col-sm-6'>
                        <div class='post'>
                            <div class='image'>
                                <a href='index.php?page=offers&pre_filter=" . $result[1] . "'>
                                    <img src='img/hotel_thumbnails/" . $result[1] . ".jpg' style=\" width: 555px; height: 370px;\">
                                </a>
                            </div>
                            <h3><a href='index.php?page=offers&pre_filter=" . $result[1] . "'>" . $result[1] . "</a></h3>
                            <p><img src='" . flagSelector($result[6]) . "' style='height: 30px; width: 50px;' alt='" . $result[6] . "'><b> " . $result[2] . "</b></p>
                            <p class='post-content'>";
                                cutStringAtLastCommaOrPeriodBeforeN($result[4], 400);
                            echo "</p>
                            <p><a href='index.php?page=offers&pre_filter=" . $result[1] . "' class='btn btn-lg btn-ghost'>Zobrazit nabídky</a></p>
                        </div>
                    </div>";
            }
            ?>
        </div>
        <div class="row">
            <?php
            for ($i = 0; $i < 3; $i++) {
                $result = $stmt->fetch(PDO::FETCH_BOTH);
                echo "
                    <div class='col-sm-4'>
                        <div class='post'>
                            <div class='image'>
                                <a href='index.php?page=offers&pre_filter=" . $result[1] . "'>
                                    <img src='img/hotel_thumbnails/" . $result[1] . ".jpg' style=\" width: 360px; height: 240px;\">
                                </a>
                            </div>
                            <h3><a href='index.php?page=offers&pre_filter=" . $result[1] . "'>" . $result[1] . "</a></h3>
                            <p><img src='" . flagSelector($result[6]) . "' style='height: 30px; width: 50px;' alt='" . $result[6] . "'><b> " . $result[2] . "</b></p>
                            <p class='post-content'>";
                                cutStringAtLastCommaOrPeriodBeforeN($result[4], 300);
                            echo "</p>
                            <p><a href='index.php?page=offers&pre_filter=" . $result[1] . "' class='btn btn-sm btn-ghost'>Zobrazit nabídky</a></p>
                        </div>
                    </div>";
            }
            ?>
        </div>
    </div>
</section>
<!--   *** SERVICES ***-->
<section class="background-gray-lightest">
    <div class="container clearfix">
        <div class="row services">
            <div class="col-md-12">
                <h2>Na cestách...</h2>
                <p class="lead margin-bottom--medium">Všechny vozy našich partnerských dopravců nabízejí
                nadstandartní služby v oblasti cestování. Vše pak dokonale dokreslí profesionálně vyškolený
                personál.</p>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="box box-services">
                            <div class="icon"><i class="pe-7s-coffee"></i></div>
                            <h4 class="services-heading">Palubní občerstvení</h4>
                            <p>Všechny vozy našich partnerských dopravců disponují širokou škálou očerstvení,
                            které Vám personál obstará kdykoliv si zamanete.</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="box box-services">
                            <div class="icon"><i class="pe-7s-monitor"></i></div>
                            <h4 class="services-heading">Zábavní termilály</h4>
                            <p>Cesta na dovolenou je dlouhá a nemůžete se dočkat? Zkraťte si cestu poslechem hudby,
                                filmem či videohrou!</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="box box-services">
                            <div class="icon"><i class="pe-7s-signal"></i></div>
                            <h4 class="services-heading">Wi-Fi</h4>
                            <p>V dnešní době je připojení k wi-fi téměř kdekoliv, i tak ale stále není samozřejmostí.
                            Nebo ano? U nás určitě ANO!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
