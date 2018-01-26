<?php


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
                        <input type='hidden' id='updated_country_name_id' name='updated_country_name_id' value='" . $result[0] . "'>
                        <input type='text' id='updated_country_name' name='updated_country_name' value='" . $result[1] . "' class='form-group-sm'>
                    </td>
                    <td>
                        <button type='submit' class='btn btn-xs btn-ghost'>Upravit</button>
                    </td>
                    <td style='text-align: center'>
                        <a href='index.php?page=administration&table=destinations&delete_country=true&country_id=" . $result[0] . "' class='btn btn-xs btn-danger'>x</a>
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
                        <input type='hidden' id='updated_city_name_id' name='updated_city_name_id' value='" . $result[0] . "'>
                        <input type='text' id='updated_city_name' name='updated_city_name' value='" . $result[1] . "' class='form-group-sm'>
                    </td>
                    <td>
                        <select id='city_country_id' class='dropdown'>";
        $stmt2 = $conn->prepare("SELECT * FROM countries");
        $stmt2->execute();
        while ($result2 = $stmt2->fetch(PDO::FETCH_BOTH)) {
            echo "<option value='" . $result2[0] . "'>" . $result2[1] . "</option>";
        }
        echo "</select>
                    </td>
                    <td>
                        <button type='submit' class='btn btn-xs btn-ghost'>Upravit</button>
                    </td>
                    <td style='text-align: center'>
                        <a href='index.php?page=administration&table=destinations&delete_city=true&city_id=" . $result[0] . "' class='btn btn-xs btn-danger'>x</a>
                    </td>
                </form>
              </tr>";
    }
}

?>
<section class="blog-post">
    <div class="row">
        <div class="col-md-6">
            <h3>Správa zemí</h3>
            <table class="table">
                <tr>
                    <td colspan="4" style="text-align: center">
                        <a href="#" data-toggle="modal" data-target="#new-country-modal" class="btn btn-ghost">Přidat
                            zemi</a>
                    </td>
                </tr>
                <tr>
                    <th> ID</th>
                    <th> Název</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php countriesTable(); ?>
            </table>
        </div>
    </div>
    <hr/><br/>
    <div class="row">
        <div class="col-md-6">
            <h3>Správa měst</h3>
            <table class="table">
                <tr>
                    <td colspan="5" style="text-align: center;">
                        <a href="#" data-toggle="modal" data-target="#new-city-modal" class="btn btn-ghost">Přidat
                            město</a>
                    </td>
                </tr>
                <tr>
                    <th>ID</th>
                    <th>Název</th>
                    <th>Země</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php citiesTable(); ?>
            </table>
        </div>
    </div>
    <hr/><br/>
    <div class="row">
        <div class="col-md-6">
            <p>efsef</p>
            <p>efsef</p>
            <p>efsef</p>
        </div>
    </div>
</section>
<!-- ***---MODALS---*** -->
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