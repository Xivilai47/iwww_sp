<?php
if (isset($_GET['offer_id'])) {
    $stmt = $conn->prepare("SELECT * FROM pretty_offer WHERE id=" . $_GET['offer_id']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_BOTH);
    $zeme = $result[1];
    $mesto = $result[2];
    $hotel = $result[3];
    $poc_luzek = $result[4];
    $od = $result[5];
    $do = $result[6];
    $cena = $result[7];
    $rezervovano_id = $result[8];
    $detail_nabidky = $result[9];
    $desc_hotelu = $result[10];
    $hotel_id = $result[11];
}

function flagSelector($zeme)
{
    $imgPath = '';
    switch ($zeme) {
        case 'Bali':
            $imgPath = "img/flags/bali_flag.jpg";
            break;
        case 'Austrálie':
            $imgPath = "img/flags/australian_flag.jpg";
            break;
        case 'Finsko':
            $imgPath = "img/flags/finland_flag.jpg";
            break;
        case 'Španělsko':
            $imgPath = "img/flags/spain_flag.jpg";
            break;
        case 'Itálie':
            $imgPath = "img/flags/italy_flag.jpg";
            break;
        case 'Francie':
            $imgPath = "img/flags/france_flag.jpg";
            break;
        case 'Řecko':
            $imgPath = "img/flags/greece_flag.jpg";
            break;
        case 'Velká Británie':
            $imgPath = "img/flags/uk_flag.jpg";
            break;
        case 'USA':
            $imgPath = "img/flags/usa_flag.jpg";
            break;
    }
    return $imgPath;
}

?>

<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
    tinymce.init({
        selector: 'textarea',
        toolbar1: 'removeformat',
    })
</script>

<section class="background-gray-lightest">
    <div class="container">
        <div class="breadcrumbs">
            <ul class="breadcrumb">
                <li><a href="index.php">Domů</a></li>
                <li><a href="index.php?page=offers">Naše nabídka</a></li>
                <li>Detail nabídky (ID: <?php echo $_GET['offer_id']; ?>)</li>
            </ul>
        </div>

        <?php
        $img_path = flagSelector($zeme);

        echo "<h2><img src=" . $img_path . " title=" . $zeme . "> " . $mesto . " - " . $hotel . "</h2>";
        ?>

        <div class="row">
            <div class="col-lg-6">
                <p class="lead"><b>Od: </b><?php echo $od; ?></p>
                <p class="lead"><b>Do: </b><?php echo $do; ?></p>
                <p class="lead"><b>Počet lůžek v pokoji: </b><?php echo $poc_luzek; ?></p>
                <p class="lead"><b>Stav: </b><?php if (empty($rezervovano_id)) {
                        echo "volné";
                    } else {
                        echo "zarezervováno";
                    } ?></p>
                <p class="lead"
                   style="text-align: right; color: red; font-size: 40px; font-weight: bolder"><?php echo $cena . " Kč"; ?></p>
                <?php
                $stmt = $conn->prepare("SELECT user_id FROM offers WHERE id=" . $_GET['offer_id']);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_BOTH);
                if (!isset($_SESSION['userID'])) {
                    echo "<button class='btn btn-ghost' disabled>Nejste přihlášen</button>";
                } else {
                    if ($result[0] != null) {
                        if ($result[0] == $_SESSION['userID']) {
                            echo "<p class='lead alert-success'>Tato nabídka je zarezervována na Vaše jméno.</p>
                              <a href='index.php?page=offer_detail&offer_id=" . $_GET['offer_id'] . "&cancel=true'
                                 class='btn btn-ghost' 
                                 onclick='return confirm(\"Opravdu si přejete zrušit rezervaci?\");'>Zrušit rezervaci</a>";
                        } else {
                            echo "<p class='lead alert-danger'>Tato nabídka je již zarezervována jiným uživatelem.</p>";
                        }
                    } else {
                        echo "<a href='index.php?page=offer_detail&make_reservation=true&offer_id=" . $_GET['offer_id'] . "'
                                 class='btn btn-ghost'>Zarezervovat!</a>";
                    }
                }
                ?>
            </div>
            <div class="col-lg-4">
                <div class="hotel-img" style="background-image: url('img/hotel_thumbnails/<?php echo $hotel; ?>.jpg')">
                </div>
            </div>
        </div>
        <br/><br/>

        <!-- POPISY -->
        <div class="row">
            <div class="col-lg-12">
                <h3>Popis nabídky: </h3>
                <?php
                if (!empty($detail_nabidky)) {
                    echo "<p class='lead'>" . $detail_nabidky . "</p>";
                } else {
                    echo "<p class='lead text-danger'>K této nabídce zatím neexistuje žádný popis.</p>";
                }
                if (isset($_SESSION['uRole'])) {
                    if ($_SESSION['uRole'] == 'Admin') {
                        echo "<a href='#' class='btn btn-ghost' data-toggle='modal' data-target='#edit-offer-desc-modal'>upravit popis</a>";
                    }
                }
                ?>
            </div>
        </div>
        <br/><br/>
        <div class="row">
            <div class="col-lg-12">
                <h3>Popis destinace: </h3>
                <?php
                if (!empty($desc_hotelu)) {
                    echo "<p class='lead'>" . $desc_hotelu . "</p>";
                } else {
                    echo "<p class='lead text-danger'>K této destinaci zatím neexistuje žádný popis.</p>";
                }
                if (isset($_SESSION['uRole'])) {
                    if ($_SESSION['uRole'] == 'Admin') {
                        echo "<a href='#' class='btn btn-ghost' data-toggle='modal' data-target='#edit-dest-desc-modal'>upravit popis</a>";
                    }
                }
                ?>
            </div>
        </div>

        <!-- GALERIE -->
        <div class="row">
            <div class="col-lg-12">
                <br/><br/>
                <h3>Galerie</h3>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row no-space">
                <?php
                $i = 0;
                foreach (glob("img/hotels/" . $hotel . "/*.jpg") as $filename) {
                    $i++;
                    echo "<div class=\"col-lg-3 col-sm-4 col-xs-6\">
                                <div class='box'>
                                    <a href='" . $filename . "' title='' data-lightbox='portfolio' data-title='" . $hotel . $i . "'>
                                        <img src='" . $filename . "' alt='' class='img-responsive' style='margin: 1px; width: 285px; height: 188px;'>
                                    </a>
                                </div>
                              </div>";
                }
                ?>
            </div>
        </div>

        <!-- KOMENTÁŘE -->
        <div class="row">
            <div class="col-lg-12">
                <br/><br/>
                <h3>Komentáře</h3>
            </div>
        </div>
        <?php
        $stmt = $conn->prepare("
              SELECT users.First_name, users.Surname, users.login, comment, created, hodnoceni 
              FROM comments JOIN users ON comments.user_ID = users.id WHERE hotel_id=" . $hotel_id . " ORDER BY created DESC");
        $stmt->execute();
        $rowCount = $stmt->rowCount();
        if($rowCount == 0){
            echo "<p><b style='color: red;'>K této destinaci zatím nebyly vloženy žádné komentáře.</b></p>";
        }
        while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
            echo "
                <div class=\"row\">
                    <div class=\"col-md-2\">
                        <table class=\"table-bordered\">
                            <tr>
                                <td style=\"width: 150px; height: 150px; text-align: center; vertical-align: middle\">
                                    <img src=\"img/profile_pics/default.png\" style=\"width: 60px; height: 60px;\"><br/><br/>
                                    $result[0] $result[1]
                                    <br/>
                                    $result[2]
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class=\"col-md-10 table-bordered\">
                        <div style=\"height: 30px;\"><b>Vloženo: $result[4]</b></div>
                        <div style=\"height: 95px; text-indent: 10px;\">$result[3]</div>
                        <div style=\"height: 25px;\"><b>Hodnocení destinace: $result[5]</b></div>
                    </div>
                </div>
                <br/>
                ";
        }
        ?>
        <div class="row">
            <h4>Přidat komentář...</h4>
            <div class="col-md-12">
                <textarea id="new_comment" name="new_comment" form="new_comment_form">

                </textarea>
            </div>
            <form id="new_comment_form" method="post" action="index.php?page=offer_detail&offer_id=<?php echo $_GET['offer_id']?>">
                <input type="hidden" value="<?php $_GET['offer_id']?>" id="new_comment_offer_id" name="new_comment_offer_id">
                <input type="hidden" value="<?php echo $hotel_id?>" id="new_comment_hotel_id" name="new_comment_hotel_id">
                <input type="number" id="new_comment_hodnoceni" name="new_comment_hodnoceni" placeholder="Hodnocení destinace (0 - 10)" min="0" max="10" required>
                <input type="submit" value="Vložit" class="btn btn-ghost">
            </form>
        </div>
    </div>
</section>

<!-- edit offer desc -->
<div id="edit-offer-desc-modal" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" class="close">×</button>
                <h4 id="edit_offer_desc" class="modal-title">Upravit popis nabídky</h4>
            </div>
            <div class="modal-body">
                <form action="index.php?page=offer_detail&edit_offer_desc=true&offer_id=<?php echo $_GET['offer_id']; ?>"
                      method="post" id="editOfferDesc">
                    <div class="form-group">
                        <h5>Popis nabídky: </h5>
                        <textarea rows="4" cols="98" form="editOfferDesc"
                                  name="edit_offer_desc"><?php echo $detail_nabidky; ?></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-ghost">Uložit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- edit dest desc -->
<div id="edit-dest-desc-modal" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" class="close">×</button>
                <h4 id="edit_dest_desc" class="modal-title">Upravit popis destinace</h4>
            </div>
            <div class="modal-body">
                <form action="index.php?page=offer_detail&edit_dest_desc=true&offer_id=<?php echo $_GET['offer_id']; ?>"
                      method="post" id="editDestDesc">
                    <div class="form-group">
                        <h5>Popis destinace: </h5>
                        <textarea rows="4" cols="98" form="editDestDesc"
                                  name="edit_dest_desc"><?php echo $desc_hotelu; ?></textarea>
                    </div>
                    <div class="form-group" style="text-align: right;">
                        <button type="submit" class="btn btn-ghost">Uložit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>