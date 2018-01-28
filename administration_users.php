<?php
function roleCB($selectedVal)
{
    if ($selectedVal == 1) {
        echo "<option value='1' selected>Admin</option>
              <option value='2'>Uživatel</option>";
    } else {
        echo "<option value='1'>Admin</option>
              <option value='2' selected>Uživatel</option>";
    }
}

?>

<div class="row">
    <div class="container">
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Jméno</th>
                <th>Příjmení</th>
                <th>e-mail</th>
                <th>Přihlašovací jméno</th>
                <th>Role</th>
                <th>Upravit</th>
                <th>Odstranit</th>
            </tr>
            <?php
            $stmt = $conn->prepare("SELECT id, First_name, Surname, email, login, role_id FROM users");
            $stmt->execute();
            while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                echo "
                    <tr>
                        <form action=\"index.php?page=administration&table=users&edit_user=true\" method=\"post\">
                            <td>" . $result[0] . "</td>
                            <td>
                                <input id='updated_user_id' name='updated_user_id' type='hidden' class='form-control' value='". $result[0] ."'>
                                <input id='updated_user_Fname' name='updated_user_Fname' type='text' class='form-control' value='" . $result[1] . "'>
                            </td>
                            <td>
                                <input id='updated_user_Surname' name='updated_user_Surname' type='text' class='form-control' value='" . $result[2] . "'>
                            </td>
                            <td>
                                <input id='updated_user_email' name='updated_user_email' type='email' class='form-control' value='" . $result[3] . "'>
                            </td>
                            <td>
                                " . $result[4] . "
                            </td>
                            <td>
                                <select id='updated_user_role_id' name='updated_user_role_id' class='dropdown form-control'>
                                    "; roleCB($result[5]); echo "
                                </select>
                            </td>
                            <td>
                                <button type='submit' class='btn btn-md btn-ghost'>Upravit</button>
                            </td>
                            <td>
                                <a href='index.php?page=administration&table=users&delete_user=true&user_id=" . $result[0] . "' class='btn btn-md btn-danger'>x</a>
                            </td>
                        </form>
                    </tr>        
                    ";
            }
            ?>
            </form>
            </tr>
        </table>
    </div>
</div>