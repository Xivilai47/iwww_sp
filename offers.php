<?php

function loadComboBox($loadWhat)
{
    global $conn;
    $query = '';
    switch ($loadWhat) {
        case 'countries':
            $query = "SELECT nazev FROM countries";
            break;
        case 'cities':
            $query = "SELECT nazev FROM cities";
            break;
        case 'hotels':
            $query = "SELECT nazev FROM hotels";
            break;
    }
    $stmt = $conn->prepare($query);
    $stmt->execute();
    while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
        echo "<option value='" . $result[0] . "'>" . $result[0] . "</option>";
    }
}

$searchHotel='';
if(isset($_GET['pre_filter'])){
    $searchHotel = $_GET['pre_filter'];
}
?>

<section class="background-gray-lightest">
    <div class="container">
        <div class="breadcrumbs">
            <ul class="breadcrumb">
                <li><a href="index.php">Domů</a></li>
                <li>Naše Nabídka</li>
            </ul>
        </div>

        <div class="row">
            <h1>Kompletní nabídka</h1>
            <p class="lead">Zde naleznete kompletní seznam všech právě nabízených zájezdů, které jsou volné k rezervaci.
                Kliknutím na jeden z náhledů budete odkázání na stránku s detaily nabídky, kde si ji můžete rovnou zarezervovat.</p>
            <table class="table">
                <tr>
                    <td colspan="7" style="border-top: none; border-bottom: solid 1px lightgray; text-align: center;">
                        <h2>Vyhledávání</h2>
                        <input type="text" id="search_By_Country" onkeyup="searchByCountry()" placeholder="Hledat dle země...">
                        <input type="text" id="search_By_City" onkeyup="searchByCity()" placeholder="Hledat dle města...">
                        <input type="text" id="search_By_Name" onkeyup="searchByName()" placeholder="Hledat dle názvu hotelu..." value="<?php echo $searchHotel?>">
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <script>
        function searchByName() {
            var input, filter, ul, li, h3, i;
            input = document.getElementById("search_By_Name");
            filter = input.value.toUpperCase();
            ul = document.getElementById("searchableUL");
            li = ul.getElementsByTagName("li");
            for (i = 0; i < li.length; i++) {
                h3 = li[i].getElementsByTagName("h3")[0];
                if (h3.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";

                }
            }
        }

        function searchByCountry() {
            var input, filter, ul, li, img, alt, i;
            input = document.getElementById("search_By_Country");
            filter = input.value.toUpperCase();
            ul = document.getElementById("searchableUL");
            li = ul.getElementsByTagName("li");
            for (i = 0; i < li.length; i++) {
                img = li[i].getElementsByTagName("img")[1];
                alt = img.getAttribute("alt");
                if (alt.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";

                }
            }
        }

        function searchByCity() {
            var input, filter, ul, li, b, i;
            input = document.getElementById("search_By_City");
            filter = input.value.toUpperCase();
            ul = document.getElementById("searchableUL");
            li = ul.getElementsByTagName("li");
            for (i = 0; i < li.length; i++) {
                b = li[i].getElementsByTagName("b")[0];
                if (b.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";

                }
            }
        }

    </script>
    <div class="container">
        <ul id="searchableUL">
            <?php
            $stmt = $conn->prepare("select *, isnull(pretty_offer.user_id) as rezervovano from pretty_offer");
            $stmt->execute();
            while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                echo "
                    <li>
                        <div class='col-sm-3'>
                            <div class='post background-gray-lighter offer'>
                                <div class=\"image\">";
                            if($result[12] == 0){
                                echo "<p class='btn alert-danger' style='position: absolute; left: 40px; top: 65px'>JIŽ REZERVOVÁNO</p>";
                            }
                            echo "
                                    <a href=\"http://localhost/index.php?page=offer_detail&offer_id=" . $result[0] . "\">
                                        <img src='img/hotel_thumbnails/" . $result[3] . ".jpg' style=\"width: 250px; height: 170px;\">
                                    </a>
                                </div>
                                <h3 style=\"margin-bottom: 10px; height: 55px;\"><a href=\"http://localhost/index.php?page=offer_detail&offer_id=" . $result[0] . "\">" . $result[3] . "</a></h3>
                                <p><img src='" . flagSelector($result[1]) . "' style=\"height: 30px; width: 50px;\" alt='" . $result[1] . "'><b> " . $result[2] . "</b></p>
                                <b>$result[5] - $result[6]</b><br/>
                                <b>Pro $result[4] osoby</b><br/>";
                                $stmt2 = $conn->prepare("select hotel_id, format(avg(hodnoceni),1) from comments where hotel_id=".$result[11]);
                                $stmt2->execute();
                                $result2 = $stmt2->fetch(PDO::FETCH_BOTH);
                                switch($result2[1]){
                                    case ($result2[1] >= 9):
                                        echo "Hodnocení hotelu: <b style='color: lightgreen; text-shadow: 0 0 1px #000, 0 0 1px #000;'>$result2[1]</b>";
                                        break;
                                    case ($result2[1] >= 8):
                                        echo "Hodnocení hotelu: <b style='color: greenyellow; text-shadow: 0 0 1px #000, 0 0 1px #000;'>$result2[1]</b>";
                                        break;
                                    case ($result2[1] >= 7):
                                        echo "Hodnocení hotelu: <b style='color: yellow; text-shadow: 0 0 1px #000, 0 0 1px #000;'>$result2[1]</b>";
                                        break;
                                    case ($result2[1] >= 6):
                                        echo "Hodnocení hotelu: <b style='color: #ffbb00; text-shadow: 0 0 1px #000, 0 0 1px #000;'>$result2[1]</b>";
                                        break;
                                    case ($result2[1] >= 5):
                                        echo "Hodnocení hotelu: <b style='color: #ff8800; text-shadow: 0 0 1px #000, 0 0 1px #000;'>$result2[1]</b>";
                                        break;
                                    case ($result2[1] < 5):
                                        echo "Hodnocení hotelu: <b style='color: #ff4444; text-shadow: 0 0 1px #000, 0 0 1px #000;'>$result2[1]</b>";
                                        break;
                                }
                                echo "
                                    <div style=\"margin-top: 10px\">
                                        <div class=\"row\">
                                            <p style=\"font-size: 24px; color: red; font-weight: bolder\">" . $result[7] . " Kč</p>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </li>";
            }
            ?>
        </ul>
    </div>
</section>

<script>
    searchByName();
</script>