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

<!-- *** NEW OFFER MODAL *** -->
<div id="new-offer-modal" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" class="close">×</button>
                <h4 id="create_new_offer" class="modal-title">Nová nabídka</h4>
            </div>
            <div class="modal-body">
                <form action="index.php?page=administration&new_offer=true" method="post">
                    <h5>Místnost</h5>
                    <?php
                    $stmt = $conn->prepare("SELECT * FROM countries");
                    $stmt->execute();
                    echo "<div class=\"form-group\"><select id='country_id' class='form-control' onchange='enableCity();'><option value='0'>Vyberte zemi</option>";
                    while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                        echo "<option value=" . $result[0] . ">" . $result[1] . "</option>";
                    }
                    echo "</select></div>";
                    $stmt = $conn->prepare("SELECT id, nazev FROM cities");
                    $stmt->execute();
                    echo "<div class=\"form-group\"><select id='city_id' class='form-control' disabled onchange='enableHotel();'><option value='0'>Vyberte město</option>";
                    while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                        echo "<option value=" . $result[0] . ">" . $result[1] . "</option>";
                    }
                    echo "</select></div>";
                    $stmt = $conn->prepare("SELECT id, nazev FROM hotels");
                    $stmt->execute();
                    echo "<div class=\"form-group\"><select id='hotel_id' class='form-control' disabled onchange='enableRoom();'><option value='0'>Vyberte hotel</option>";
                    while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                        echo "<option value=" . $result[0] . ">" . $result[1] . "</option>";
                    }
                    echo "</select></div>";
                    $stmt = $conn->prepare("SELECT id, concat('Lůžka: ', No_of_Beds, ', Cena/noc: ', Price_Night) FROM rooms");
                    $stmt->execute();
                    echo "<div class=\"form-group\"><select id='room_id' class='form-control' disabled><option value='0'>Vyberte místnost</option>";
                    while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                        echo "<option value=" . $result[0] . ">" . $result[1] . "</option>";
                    }
                    echo "</select></div>";
                    ?>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
<!-- *** NEW OFFER MODAL END *** -->

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
    $stmt = $conn->prepare("SELECT * FROM pretty_offer2");
    $stmt->execute();
    while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
        echo "<tr>
                                <td>$result[0]</td><td>$result[1]</td><td>$result[2]</td><td>$result[3]</td><td>$result[4]</td><td>$result[5]</td>
                                <td><a class='btn btn-xs btn-ghost' href='index.php?page=offer_detail&offer_id=" . $result[0] . "'>Detail</a></td>
                                <td><a class='btn btn-xs btn-ghost' href='#'>Upravit</a></td>
                                <td style='text-align: center'><a class='btn btn-xs btn-danger' href='#'>x</a></td>
                              </tr>";
    }
    ?>
</table>