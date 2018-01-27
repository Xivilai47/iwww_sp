<?php
function roomsComboBox($selectVal)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM pretty_rooms");
    $stmt->execute();
    while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
        if ($result[0] === $selectVal) {
            echo "<option value='" . $result[0] . "' selected>" . $result[1] . "</option>";
        } else {
            echo "<option value='" . $result[0] . "'>" . $result[1] . "</option>";
        }
    }
}

function offersTable()
{
    global $conn;
    $stmt = $conn->prepare("SELECT *, substr(pretty_room_id, 1, 1) FROM pretty_offer2");
    $stmt->execute();
    while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
        echo "<tr>
                <form action='index.php?page=administration&table=offers&edit_offer=true' method='post'>
                    <td>" . $result[0] . "</td>
                    <td>
                        <input type='hidden' id='updated_offer_id' name='updated_offer_id' value='" . $result[0] . "'>
                        <select id='updated_offer_room_id' name='updated_offer_room_id' class='dropdown form-control'>
                            ";
                            roomsComboBox($result[7]);
                            echo "
                        </select>
                    </td>
                    <td>
                        <input type='text' id='updated_offer_reserved_by' name='updated_offer_reserved_by' class='form-control' value='" . $result[2] . "'>
                    </td>
                    <td>
                        <input type='date' id='updated_offer_date_from' name='updated_offer_date_from' class='form-control' value='" . $result[3] . "'>
                    </td>
                    <td>
                        <input type='date' id='updated_offer_date_to' name='updated_offer_date_to' class='form-control' value='" . $result[4] . "'>
                    </td>
                    <td>
                        <input type='text' id='updated_offer_duration' name='updated_offer_duration' class='form-control' value='".$result[5]."'>
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

?>

<script>
    function enableCity() {
        var elementCountry = document.getElementById("country_id");
        var selIndexCountry = elementCountry.options[elementCountry.selectedIndex].value;
        if (selIndexCountry !== 0) {
            document.getElementById("city_id").removeAttribute("disabled");
        }
        else {
            document.getElementById("city_id").setAttribute("disabled", "disabled")
        }
    }

    function enableHotel() {
        var elementCity = document.getElementById("city_id");
        var selIndexCity = elementCity.options[elementCity.selectedIndex].value;
        if (selIndexCity !== 0) {
            document.getElementById("hotel_id").removeAttribute("disabled");
        }
        else {
            document.getElementById("hotel_id").setAttribute("disabled", "disabled")
        }
    }

    function enableRoom() {
        var elementHotel = document.getElementById("hotel_id");
        var selIndexHotel = elementHotel.options[elementHotel.selectedIndex].value;
        if (selIndexHotel !== 0) {
            document.getElementById("room_id").removeAttribute("disabled");
        }
        else {
            document.getElementById("room_id").setAttribute("disabled", "disabled")
        }
    }

</script>

<div class="row">
    <a href="#" data-toggle="modal" data-target="#new-offer-modal" class="btn btn-ghost">Vytvořit novou
        nabídku...</a>
</div>

<br/>
<table class="table">
    <tr>
        <th>ID nabídky</th>
        <th>ID Místností</th>
        <th>Rezervace uživatele</th>
        <th>Od</th>
        <th>Do</th>
        <th>Dní</th>
        <th>Detail</th>
        <th>Upravit</th>
        <th>Odstranit</th>
    </tr>
    <?php
    offersTable();
    /*
    $stmt = $conn->prepare("SELECT * FROM pretty_offer2");
    $stmt->execute();
    while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
        echo "<tr>
            <td>$result[0]</td><td>$result[1]</td><td>$result[2]</td><td>$result[3]</td><td>$result[4]</td><td>$result[5]</td>
            <td><a class='btn btn-xs btn-ghost' href='index.php?page=offer_detail&offer_id=" . $result[0] . "'>Detail</a></td>
            <td><a class='btn btn-xs btn-ghost' href='#' data-toggle='modal' data-target='#edit-offer-modal'>Upravit</a></td>
            <td style='text-align: center'><a class='btn btn-xs btn-danger' href='#'>x</a></td>
        </tr>";
    }
    */
    ?>
</table>

<!-- *** --- MODALS --- *** -->

<!-- new offer 2  -->
<div id="new-offer-modal" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" class="close">×</button>
                <h4 id="create_new_offer" class="modal-title">Nová nabídka</h4>
            </div>
            <div class="modal-body">
                <form action="index.php?page=administration&table=offers&new_offer=true" method="post">
                    <h5>Místnost</h5>
                    <div class="form-group">
                        <select id="room_id" name="room_id" class="form-control">
                            <option value='0'>Vyberte místnost</option>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM pretty_rooms");
                            $stmt->execute();
                            $i = 0;
                            while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                                echo "<option value=" . $i . ">" . $result[0] . "</option>";
                                $i++;
                            }
                            ?>
                        </select>
                    </div>
                    <h5>Datum od: </h5>
                    <div class="form-group">
                        <input type="date" id="date_from" name="date_from" class="form-control">
                    </div>
                    <h5>Datum do: </h5>
                    <div class="form-group">
                        <input type="date" id="date_to" name="date_to" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-ghost">Vložit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- new offer old -->
<div id="new-offer-modal" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" class="close">×</button>
                <h4 id="create_new_offer" class="modal-title">Nová nabídka</h4>
            </div>
            <div class="modal-body">
                <form action="index.php?page=administration&table=offers&new_offer=true" method="post">
                    <h5>Místnost</h5>
                    <div id="country_CB" class="form-group">
                        <select id="country_id" name="country_id" class="form-control" onchange="enableCity()">
                            <option value='0'>Vyberte zemi</option>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM countries");
                            $stmt->execute();
                            while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                                echo "<option value=" . $result[0] . ">" . $result[1] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div id="city_CB" class="form-group">
                        <select id="city_id" name="city_id" class="form-control" disabled onchange="enableHotel();">
                            <option value='0'>Vyberte město</option>
                            <?php
                            $stmt = $conn->prepare("SELECT id, nazev FROM cities");
                            $stmt->execute();
                            while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                                echo "<option value=" . $result[0] . ">" . $result[1] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="hotel_id" name="hotel_id" class="form-control" disabled onchange="enableRoom();">
                            <option value='0'>Vyberte hotel</option>
                            <?php
                            $stmt = $conn->prepare("SELECT id, nazev FROM hotels");
                            $stmt->execute();
                            while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                                echo "<option value=" . $result[0] . ">" . $result[1] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <select id="room_id" name="room_id" class="form-control" disabled>
                            <option value='0'>Vyberte místnost</option>
                            <?php
                            $stmt = $conn->prepare("SELECT id, concat('Lůžka: ', No_of_Beds, ', Cena/noc: ', Price_Night) FROM rooms");
                            $stmt->execute();
                            while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                                echo "<option value=" . $result[0] . ">" . $result[1] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <h5>Datum od: </h5>
                    <div class="form-group">
                        <input type="date" id="date_from" name="date_from" class="form-control">
                    </div>
                    <h5>Datum do: </h5>
                    <div class="form-group">
                        <input type="date" id="date_to" name="date_to" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-ghost">Vložit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>