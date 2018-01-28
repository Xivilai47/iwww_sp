<section class="background-gray-lightest">
    <div class="container">
        <div class="breadcrumbs">
            <ul class="breadcrumb">
                <li><a href="index.php">Domů</a></li>
                <li>Můj profil</li>
            </ul>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <?php
                echo "<h1>" . $_SESSION['uFirstName'] . " " . $_SESSION['uSurname'] . "</h1>";
                echo "<p class='lead'>Přihlašovací jmnéno: " . $_SESSION['uLogin'] . "<br/>
                                  e-mail: " . $_SESSION['uEmail'] . "<br/>
                                  ID uživatele: " . $_SESSION['userID'] . "<br/>
                                  Role: " . $_SESSION['uRole'] . "
                                  </p>";
                ?>
                <a class="btn btn-ghost" href="index.php?logout=true"><i class="fa fa-sign-out"></i>Odhlásit</a>
            </div>
            <div class="col-lg-6" style="text-align: center;">
                <?php
                $stmt = $conn->prepare("SELECT profile_picture FROM users WHERE id = " . $_SESSION['userID']);
                $stmt->execute();
                while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                    echo "<img src='" . $result[0] . "' style=\"width:200px; height: 200px;\";/><br/><br/>";
                }
                ?>
                <a href="#" class="btn btn-ghost">Změnit obrázek</a>

            </div>
        </div>


        <br/><br/><br/>
        <h3>Moje rezervace</h3>
        <p class="lead">Zde můžete vidět všechny vaše rezervace v přehledné tabulce.</p>
        <table class="table">
            <tr>
                <th>
                    ID nabídky
                </th>
                <th>
                    Země
                </th>
                <th>
                    Město
                </th>
                <th>
                    Hotel
                </th>
                <th>
                    Počet lůžek
                </th>
                <th>
                    Od
                </th>
                <th>
                    Do
                </th>
                <th>
                    Cena (Kč)
                </th>
                <th>
                </th>
                <th>
                </th>
            </tr>
            <?php
            $stmt = $conn->prepare("SELECT * FROM `pretty_offer` WHERE `user_id` = " . $_SESSION['userID']);
            $stmt->execute();
            $no_of_records = 0;
            while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                $no_of_records++;
                echo "<tr>
                      <td>$result[0]</td><td>$result[1]</td><td>$result[2]</td><td>$result[3]</td><td>$result[4]</td>
                      <td>$result[5]</td><td>$result[6]</td><td>$result[7]</td><td>
                        <a class='btn btn-ghost' href='index.php?page=offer_detail&offer_id=" . $result[0] . "'>Detail</a>
                      </td><td>
                        <a class='btn btn-ghost' href='index.php?page=profile&cancel=true&offer_id=" . $result[0] . "' 
                            onclick='return confirm(\"Opravdu si přejete zrušit rezervaci?\");'>Zrušit rezervaci</a>
                      </td>
                      </tr>";
            }
            if ($no_of_records === 0) {
                echo "<tr><td colspan='8' style='text-align: center; font-style: italic; color: red;'>
                        V současné době nemáte žádné rezervace.
                    </td></tr>";
            }
            ?>

        </table>
    </div>
</section>