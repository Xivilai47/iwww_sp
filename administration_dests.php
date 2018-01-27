<?php

function countriesComboBox($selectVal)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM countries");
    $stmt->execute();
    while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
        if ($result[0] === $selectVal) {
            echo "<option value='" . $result[0] . "' selected>" . $result[1] . "</option>";
        } else {
            echo "<option value='" . $result[0] . "'>" . $result[1] . "</option>";
        }
    }
}

function citiesComboBox($selectVal)
{
    global $conn;
    $stmt = $conn->prepare("SELECT id, nazev FROM cities");
    $stmt->execute();
    while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
        if ($result[0] === $selectVal) {
            echo "<option value='" . $result[0] . "' selected>" . $result[1] . "</option>";
        } else {
            echo "<option value='" . $result[0] . "'>" . $result[1] . "</option>";
        }
    }
}

function hotelsComboBox($selectVal)
{
    global $conn;
    $stmt = $conn->prepare("SELECT id, nazev FROM hotels");
    $stmt->execute();
    while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
        if ($result[0] === $selectVal) {
            echo "<option value='" . $result[0] . "' selected>" . $result[1] . "</option>";
        } else {
            echo "<option value='" . $result[0] . "'>" . $result[1] . "</option>";
        }
    }
}

function yesNoComboBox($selectedVal)
{
    if ($selectedVal == 0) {
        echo "<option value='0' selected>Ne</option>
              <option value='1'>Ano</option>";
    } else {
        echo "<option value='0'>Ne</option>
              <option value='1' selected>Ano</option>";
    }
}

function countriesTable()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM countries");
    $stmt->execute();
    while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
        echo "<tr>
                <form action='index.php?page=administration&table=destinations&edit_country=true' method='post'>
                    <td>" . $result[0] . "</td>
                    <td>
                        <input type='hidden' id='updated_country_id' name='updated_country_id' value='" . $result[0] . "'>
                        <input type='text' id='updated_country_name' name='updated_country_name' value='" . $result[1] . "' class='form-control'>
                    </td>
                    <td>
                        <button type='submit' class='btn btn-md btn-ghost'>Upravit</button>
                    </td>
                    <td style='text-align: center'>
                        <a href='index.php?page=administration&table=destinations&delete_country=true&country_id=" . $result[0] . "' class='btn btn-md btn-danger'>x</a>
                    </td>
                </form>
              </tr>";
    }
}

function citiesTable()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM cities");
    $stmt->execute();
    while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
        echo "<tr>
                <form action='index.php?page=administration&table=destinations&edit_city=true' method='post'>
                    <td>" . $result[0] . "</td>
                    <td>
                        <input type='hidden' id='updated_city_id' name='updated_city_id' value='" . $result[0] . "'>
                        <input type='text' id='updated_city_name' name='updated_city_name' value='" . $result[1] . "' class='form-control'>
                    </td>
                    <td>
                        <select id='updated_city_country_id' name='updated_city_country_id' class='dropdown form-control'>
                            ";
        countriesComboBox($result[2]);
        echo "
                        </select>
                    </td>
                    <td>
                        <button type='submit' class='btn btn-md btn-ghost'>Upravit</button>
                    </td>
                    <td style='text-align: center'>
                        <a href='index.php?page=administration&table=destinations&delete_city=true&city_id=" . $result[0] . "' class='btn btn-md btn-danger'>x</a>
                    </td>
                </form>
              </tr>";
    }
}

function hotelsTable()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM hotels");
    $stmt->execute();
    while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
        echo "<tr>
                <form action='index.php?page=administration&table=destinations&edit_hotel=true' method='post'>
                    <td>" . $result[0] . "</td>
                    <td>
                        <input type='hidden' id='updated_hotel_id' name='updated_hotel_id' value='" . $result[0] . "'>
                        <input type='text' id='updated_hotel_name' name='updated_hotel_name' value='" . $result[1] . "' class='form-control'>
                    </td>
                    <td>
                        <select id='updated_hotel_city_id' name='updated_hotel_city_id' class='dropdown form-control'>
                        ";
        citiesComboBox($result[2]);
        echo "
                        </select>
                    </td>
                    <td>
                        <button type='submit' class='btn btn-md btn-ghost'>Upravit</button>
                    </td>
                    <td style='text-align: center'>
                        <a href='index.php?page=administration&table=destinations&delete_hotel=true&hotel_id=" . $result[0] . "' class='btn btn-md btn-danger'>x</a>
                    </td>
                </form>
              </tr>";
    }
}

function roomsTable()
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM rooms");
    $stmt->execute();
    while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
        echo "<tr>
                <form action='index.php?page=administration&table=destinations&edit_room=true' method='post'>
                    <td>" . $result[0] . "</td>
                    <td>
                        <input type='hidden' id='updated_room_id' name='updated_room_id' value='" . $result[0] . "'>
                        <input type='text' id='updated_room_no_of_beds' name='updated_room_no_of_beds' value='" . $result[1] . "' class='form-control'>
                    </td>
                    <td>
                        <input type='text' id='updated_room_price_night' name='updated_room_price_night' value='" . $result[2] . "' class='form-control'>
                    </td>
                    <td>
                        <select id='updated_room_hotel_id' name='updated_room_hotel_id' class='dropdown form-control'>
                            ";
        hotelsComboBox($result[4]);
        echo "
                        </select>
                    </td>
                    <td>
                        <button type='submit' class='btn btn-md btn-ghost'>Upravit</button>
                    </td>
                    <td style='text-align: center'>
                        <a href='index.php?page=administration&table=destinations&delete_room=true&room_id=" . $result[0] . "' class='btn btn-md btn-danger'>x</a>
                    </td>
                </form>
              </tr>";
    }
}

?>

<div class="breadcrumbs">
    <ul class="breadcrumb">
        <li><a href="#admin_countries">Země</a></li>
        <li><a href="#admin_cities">Města</a></li>
        <li><a href="#admin_hotels">Hotely</a></li>
        <li><a href="#admin_rooms">Místnosti</a></li>
</div>
<hr/>
<section class="blog-post">
    <div class="row">
        <div class="col-md-8">
            <a name="admin_countries" class="anchor"><h3>Správa zemí</h3></a>
            <a href="#admin_top" class="breadcrumb">Nahoru</a><br/><br/>
            <table class="table">
                <tr>
                    <th> ID</th>
                    <th> Název</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php countriesTable(); ?>
                <tr>
                    <td colspan="4" style="text-align: center">
                        <a href="#" data-toggle="modal" data-target="#new-country-modal" class="btn btn-ghost">Přidat
                            zemi</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <hr/>
    <br/>
    <div class="row">
        <div class="col-md-8">
            <a name="admin_cities" class="anchor"><h3>Správa měst</h3></a>
            <a href="#admin_top" class="breadcrumb">Nahoru</a><br/><br/>
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th width="270px">Název</th>
                    <th width="230px">Země</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php citiesTable(); ?>
                <tr>
                    <td colspan="5" style="text-align: center;">
                        <a href="#" data-toggle="modal" data-target="#new-city-modal" class="btn btn-ghost">Přidat
                            město</a>
                    </td>
                </tr>
                <tr>
            </table>
        </div>
    </div>
    <hr/>
    <br/>
    <div class="row">
        <div class="col-md-8">
            <a name="admin_hotels" class="anchor"><h3>Správa hotelů</h3></a>
            <a href="#admin_top" class="breadcrumb">Nahoru</a><br/><br/>
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th width="270px">Název</th>
                    <th width="230px">Město</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php hotelsTable(); ?>
                <tr>
                    <td colspan="5" style="text-align: center;">
                        <a href="#" data-toggle="modal" data-target="#new-hotel-modal" class="btn btn-ghost">Přidat
                            hotel</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <hr/>
    <br/>
    <div class="row">
        <div class="col-md-8">
            <a name="admin_rooms" class="anchor"><h3>Správa mísntostí</h3></a>
            <a href="#admin_top" class="breadcrumb">Nahoru</a><br/><br/>
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th width="100px">Počet lůžek</th>
                    <th width="120px">Cena za noc</th>
                    <th>Hotel</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php roomsTable(); ?>
                <tr>
                    <td colspan="7" style="text-align: center;">
                        <a href="#" data-toggle="modal" data-target="#new-room-modal" class="btn btn-ghost">Přidat
                            mísntost</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</section>

<!-- *** --- MODALS --- *** -->
<!-- country -->
<div id="new-country-modal" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" class="close">×</button>
                <h4 id="new_country" class="modal-title">Přidat zemi</h4>
            </div>
            <div class="modal-body">
                <form action="index.php?page=administration&table=destinations&new_coutry=true" method="post">
                    <div class="form-group">
                        <h5>Název země: </h5>
                        <input id="new_country_nazev" name="new_country_nazev" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-ghost">Vložit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- city -->
<div id="new-city-modal" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" class="close">×</button>
                <h4 id="new_city" class="modal-title">Přidat město</h4>
            </div>
            <div class="modal-body">
                <form action="index.php?page=administration&table=destinations&new_city=true" method="post">
                    <div class="form-group">
                        <h5>Název města: </h5>
                        <input id="new_city_nazev" name="new_city_nazev" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <h5>Vyberte zemi: </h5>
                        <select id="new_city_country_id" name="new_city_country_id" class="dropdown form-control">
                            <?php countriesComboBox(0); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-ghost">Vložit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- hotel -->
<div id="new-hotel-modal" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" class="close">×</button>
                <h4 id="new_hotel" class="modal-title">Přidat hotel</h4>
            </div>
            <div class="modal-body">
                <form action="index.php?page=administration&table=destinations&new_hotel=true" method="post">
                    <div class="form-group">
                        <h5>Název hotelu: </h5>
                        <input id="new_hotel_nazev" name="new_hotel_nazev" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <h5>Vyberte město: </h5>
                        <select id="new_hotel_city_id" name="new_hotel_city_id" class="dropdown form-control">
                            <?php citiesComboBox(0); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-ghost">Vložit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- room -->
<div id="new-room-modal" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" class="close">×</button>
                <h4 id="new_room" class="modal-title">Přidat místnost</h4>
            </div>
            <div class="modal-body">
                <form action="index.php?page=administration&table=destinations&new_room=true" method="post">
                    <div class="form-group">
                        <h5>Počet lůžek: </h5>
                        <input id="new_room_no_of_beds" name="new_room_no_of_beds" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <h5>Cena za noc: </h5>
                        <input id="new_room_price_night" name="new_room_price_night" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <h5>Vyberte hotel: </h5>
                        <select id="new_room_hotel_id" name="new_room_hotel_id" class="dropdown form-control">
                            <?php hotelsComboBox(0); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-ghost">Vložit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>