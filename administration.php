<section class="background-gray-lightest">
    <div class="container">
        <div class="breadcrumbs">
            <ul class="breadcrumb">
                <li><a href="index.php">Domů</a></li>
                <?php
                if (isset($_GET['table'])) {
                    switch ($_GET['table']) {
                        case 'offers':
                            echo "<li>Správa nabídek</li>";
                            break;
                        case 'destinations':
                            echo "<li>Správa destinací</li>";
                            break;
                        case 'users':
                            echo "<li>Správa uživatelů</li>";
                            break;
                    }
                }
                ?>
            </ul>
        </div>
            <div class="row">
                <?php
                if (isset($_GET['table'])) {
                    switch ($_GET['table']) {
                        case 'offers':
                            echo "<h1>Správa nabídek</h1>";
                            include_once "administration_offers.php";
                            break;
                        case 'destinations':
                            echo "<h1>Správa destinací</h1>
                              <p class='lead'>Na této stránce lze spravovat veškerý obsah týkající se jednotlivých destinací. 
                              Možné je přidávání nových, úprava stávajících či jejich smazání. V blízké budoucnosti půjde 
                              i řadit a možná i filtrovat :P</p>";
                            include_once "administration_dests.php";
                            break;
                        case 'users':
                            echo "<h1>Správa uživatelů</h1>";
                            break;
                    }
                }
                ?>

            </div>
    </div>
</section>
