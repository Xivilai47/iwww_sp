<section class="background-gray-lightest">
    <div class="container">
        <div class="breadcrumbs">
            <ul class="breadcrumb">
                <li><a href="index.php">Domů</a></li>
                <?php
                    if(isset($_GET['table'])){
                        switch($_GET['table']){
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
            if(isset($_GET['table'])){
                switch($_GET['table']){
                    case 'offers':
                        echo "<h1>Správa nabídek</h1>";
                        break;
                    case 'destinations':
                        echo "<h1>Správa destinací</h1>";
                        break;
                    case 'users':
                        echo "<h1>Správa uživatelů</h1>";
                        break;
                }
            }
            ?>

            <table class="table">
                <tr>
                    <th>ID nabídky</th><th>ID Místností</th><th>Zarezervováno</th><th>Rezervace uživatele</th><th>Od</th><th>Do</th><th>Dní</th><th>Detail</th><th>Upravit</th><th>Odstranit</th>
                </tr>
                <?php
                    $stmt = $conn->prepare("select * from pretty_offer2");
                    $stmt->execute();
                    while($result = $stmt->fetch(PDO::FETCH_BOTH)){
                        echo "<tr>
                                <td>$result[0]</td><td>$result[1]</td><td>$result[2]</td><td>$result[3]</td><td>$result[4]</td><td>$result[5]</td><td>$result[6]</td>
                                <td><a class='btn btn-xs btn-ghost' href='index.php?page=offer_detail&offer_id=".$result[0]."'>Detail</a></td>
                                <td><a class='btn btn-xs btn-ghost' href='#'>Upravit</a></td>
                                <td><a class='btn btn-xs btn-ghost' href='#'>x</a></td>
                              </tr>";
                    }
                ?>
            </table>
        </div>

    </div>
</section>
