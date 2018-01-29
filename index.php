<?php session_start();

/* pripojeni k DB */
$servername = 'localhost';
$username = 'root';
$password = '';
try {
    $conn = new PDO("mysql:host=$servername;dbname=sp_test", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

/* VIEWS AND STUFF
$stmt = $conn->prepare("create or replace view pretty_rooms as 
SELECT concat(r.no_of_beds, '-lůžkový pokoj - ', h.nazev, ' (', c.Nazev, ')') as 'pokoj' from rooms r join hotels h on r.ID_Hotel = h.ID join cities c on c.ID = h.city_ID");
$stmt->execute();
*/

/* LOGIN FCE */
function login($loginName, $loginPwd)
{
    global $conn;

    $stmt = $conn->prepare("SELECT password FROM users WHERE login = '" . $loginName . "'");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if (password_verify($loginPwd, $result['password'])) {
        $stmt = $conn->prepare(
            "SELECT u.*, r.role FROM users u JOIN roles r ON u.Role_ID = r.ID WHERE login = '" . $loginName . "'");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['userID'] = $result['ID'];
        $_SESSION['uFirstName'] = $result['First_name'];
        $_SESSION['uSurname'] = $result['Surname'];
        $_SESSION['uEmail'] = $result['email'];
        $_SESSION['uLogin'] = $result['login'];
        $_SESSION['uRole'] = $result['role'];
    }
}

/* LOGIN CALL */
if (isset($_POST['input_login_modal']) && isset($_POST['input_password_modal'])) {
    login($_POST['input_login_modal'], $_POST['input_password_modal']);
}

/* LOGOUT */
if (isset($_GET['logout'])) {
    unset($_SESSION['userID']);
    unset($_SESSION['uFirstName']);
    unset($_SESSION['uSurname']);
    unset($_SESSION['uEmail']);
    unset($_SESSION['uLogin']);
    unset($_SESSION['uRole']);
}

/* REGISTRATION */
if (isset($_POST['reg_FirstName_modal']) &&
    isset($_POST['reg_Surname_modal']) &&
    isset($_POST['reg_email_modal']) &&
    isset($_POST['reg_login_modal']) &&
    isset($_POST['reg_password_modal']) &&
    isset($_POST['reg_password2_modal'])) {

    if ($_POST['reg_password_modal'] === $_POST['reg_password2_modal']) {
        addUser($_POST['reg_FirstName_modal'],
            $_POST['reg_Surname_modal'],
            $_POST['reg_email_modal'],
            $_POST['reg_login_modal'],
            $_POST['reg_password_modal']);
    }

}

function addUser($firstName, $surname, $email, $login, $pwd)
{
    global $conn;
    $stmt = $conn->prepare("INSERT INTO `users`(`First_name`, `Surname`, `email`, `login`, `password`, `Role_ID`) 
                VALUES ('" . $firstName . "', '" . $surname . "', '" . $email . "', '" . $login . "', '"
        . password_hash($pwd, PASSWORD_DEFAULT) . "', 2)");
    $stmt->execute();
}

/* make reservation */
if (isset($_GET['offer_id']) && isset($_GET['make_reservation'])) {
    $stmt = $conn->prepare("UPDATE offers SET user_id=" . $_SESSION['userID'] . " WHERE ID=" . $_GET['offer_id']);
    $stmt->execute();
    header("Location: http://localhost/index.php?page=offer_detail&offer_id=" . $_GET['offer_id']);
}

/* reservation cancel */
if (isset($_GET['offer_id']) && isset($_GET['cancel'])) {
    $stmt = $conn->prepare("UPDATE offers SET user_ID=NULL WHERE ID=" . $_GET['offer_id']);
    $stmt->execute();
    header("Location: http://localhost/index.php?page=profile");
    die();
}

/* add country */
if (isset($_GET['new_coutry']) && isset($_POST['new_country_nazev'])) {
    $stmt = $conn->prepare("INSERT INTO countries (nazev) VALUES ('" . $_POST['new_country_nazev'] . "')");
    $stmt->execute();
    header("Location: http://localhost/index.php?page=administration&table=destinations#admin_countries");
}

/* edit country */
if (isset($_GET['edit_country']) && isset($_POST['updated_country_id']) && isset($_POST['updated_country_name'])) {
    $stmt = $conn->prepare("UPDATE countries SET nazev='" . $_POST['updated_country_name'] . "' WHERE id=" . $_POST['updated_country_id']);
    $stmt->execute();
    header("Location: http://localhost/index.php?page=administration&table=destinations#admin_countries");
}

/* delete country */
if (isset($_GET['delete_country']) && isset($_GET['country_id'])) {
    $stmt = $conn->prepare("DELETE FROM countries WHERE id=" . $_GET['country_id']);
    $stmt->execute();
    header("Location: http://localhost/index.php?page=administration&table=destinations#admin_countries");
}

/* add city */
if (isset($_GET['new_city']) && isset($_POST['new_city_nazev']) && isset($_POST['new_city_country_id'])) {
    $stmt = $conn->prepare("INSERT INTO cities (nazev, country_id) VALUES ('" . $_POST['new_city_nazev'] . "', " . $_POST['new_city_country_id'] . ")");
    $stmt->execute();
    header("Location: http://localhost/index.php?page=administration&table=destinations#admin_cities");
}

/* edit city */
if (isset($_GET['edit_city']) && isset($_POST['updated_city_id']) && isset($_POST['updated_city_name']) && isset($_POST['updated_city_country_id'])) {
    $stmt = $conn->prepare("UPDATE cities SET nazev='" . $_POST['updated_city_name'] . "', country_id=" . $_POST['updated_city_country_id'] . " WHERE id=" . $_POST['updated_city_id']);
    $stmt->execute();
    header("Location: http://localhost/index.php?page=administration&table=destinations#admin_cities");
}

/* delete city */
if (isset($_GET['delete_city']) && isset($_GET['city_id'])) {
    $stmt = $conn->prepare("DELETE FROM cities WHERE id=" . $_GET['city_id']);
    $stmt->execute();
    header("Location: http://localhost/index.php?page=administration&table=destinations#admin_cities");
}

/* add hotel */
if (isset($_GET['new_hotel']) && isset($_POST['new_hotel_nazev']) && isset($_POST['new_hotel_city_id']) && isset($_POST['new_hotel_base_room_price'])) {
    $stmt = $conn->prepare("INSERT INTO hotels (nazev, city_id, base_room_price) VALUES ('" . $_POST['new_hotel_nazev'] . "', " . $_POST['new_hotel_city_id'] . ", " . $_POST['new_hotel_base_room_price'] . ")");
    $stmt->execute();
    header("Location: http://localhost/index.php?page=administration&table=destinations#admin_hotels");
}

/* edit hotel */
if (isset($_GET['edit_hotel']) && isset($_POST['updated_hotel_id']) && isset($_POST['updated_hotel_name']) && isset($_POST['updated_hotel_city_id']) && isset($_POST['updated_hotel_base_room_price'])) {
    $stmt = $conn->prepare("UPDATE hotels SET nazev='" . $_POST['updated_hotel_name'] . "', city_id=" . $_POST['updated_hotel_city_id'] . ", base_room_price=" . $_POST['updated_hotel_base_room_price'] . " WHERE id=" . $_POST['updated_hotel_id']);
    $stmt->execute();
    header("Location: http://localhost/index.php?page=administration&table=destinations#admin_hotels");
}

/* delete hotel */
if (isset($_GET['delete_hotel']) && isset($_GET['hotel_id'])) {
    $stmt = $conn->prepare("DELETE FROM hotels WHERE id=" . $_GET['hotel_id']);
    $stmt->execute();
    header("Location: http://localhost/index.php?page=administration&table=destinations#admin_hotels");
}

/* add room */
if (isset($_GET['new_room']) && isset($_POST['new_room_no_of_beds']) && isset($_POST['new_room_price_night']) && isset($_POST['new_room_hotel_id'])) {
    $stmt = $conn->prepare("INSERT INTO rooms (No_of_Beds, Price_Night, taken, id_hotel) VALUES (" . $_POST['new_room_no_of_beds'] . ", " . $_POST['new_room_price_night'] . ", 0, " . $_POST['new_room_hotel_id'] . ")");
    $stmt->execute();
    header("Location: http://localhost/index.php?page=administration&table=destinations#admin_rooms");
}

/* edit room */
if (isset($_GET['edit_room']) && isset($_POST['updated_room_id']) && isset($_POST['updated_room_no_of_beds']) && isset($_POST['updated_room_price_night']) && isset($_POST['updated_room_hotel_id'])) {
    $stmt = $conn->prepare("UPDATE rooms SET no_of_beds=" . $_POST['updated_room_no_of_beds'] . ", price_night=" . $_POST['updated_room_price_night'] . ", id_hotel=" . $_POST['updated_room_hotel_id'] . " WHERE id=" . $_POST['updated_room_id']);
    $stmt->execute();
    header("Location: http://localhost/index.php?page=administration&table=destinations#admin_rooms");
}

/* delete room */
if (isset($_GET['delete_room']) && isset($_GET['room_id'])) {
    $stmt = $conn->prepare("DELETE FROM rooms WHERE id=" . $_GET['room_id']);
    $stmt->execute();
    header("Location: http://localhost/index.php?page=administration&table=destinations#admin_rooms");
}

/* add offer */
if (isset($_GET['new_offer']) && isset($_POST['room_id']) && isset($_POST['date_from']) && isset($_POST['date_to'])) {
    $stmt = $conn->prepare("INSERT INTO offers (id_room, date_from, date_to, no_of_days) VALUES (
      " . $_POST['room_id'] . ", '" . $_POST['date_from'] . "', '" . $_POST['date_to'] . "', date_to-date_from)");
    $stmt->execute();
    header("Location: http://localhost/index.php?page=administration&table=offers");
}

/* edit offer */
if (isset($_GET['edit_offer']) && isset($_POST['updated_offer_id']) && isset($_POST['updated_offer_room_id']) && isset($_POST['updated_offer_reserved_by']) && isset($_POST['updated_offer_date_from']) && isset($_POST['updated_offer_date_to'])) {
    if($_POST['updated_offer_reserved_by'] == ''){
        $_POST['updated_offer_reserved_by'] = 'null';
    }
    $stmt = $conn->prepare("UPDATE offers SET id_room=" . $_POST['updated_offer_room_id'] . ", user_id=" . $_POST['updated_offer_reserved_by'] . ", date_from='" . $_POST['updated_offer_date_from'] . "', date_to='" . $_POST['updated_offer_date_to'] . "', no_of_days=datediff(date_to, date_from) WHERE id=" . $_POST['updated_offer_id'] . "");
    $stmt->execute();
    header("Location: http://localhost/index.php?page=administration&table=offers");
}

/* delete offer */
if (isset($_GET['delete_offer']) && isset($_GET['offer_id'])) {
    $stmt = $conn->prepare("DELETE FROM offers WHERE id=" . $_GET['offer_id']);
    $stmt->execute();
    header("Location: http://localhost/index.php?page=administration&table=offers");
}

/* edit user */
if (isset($_GET['edit_user']) && isset($_POST['updated_user_id']) && isset($_POST['updated_user_Fname']) && isset($_POST['updated_user_Surname']) && isset($_POST['updated_user_email']) && isset($_POST['updated_user_role_id'])) {
    $stmt = $conn->prepare("UPDATE users SET First_name='" . $_POST['updated_user_Fname'] . "', surname='" . $_POST['updated_user_Surname'] . "', email='" . $_POST['updated_user_email'] . "', role_id=" . $_POST['updated_user_role_id'] . " WHERE id=" . $_POST['updated_user_id']);
    $stmt->execute();
    header("Location: http://localhost/index.php?page=administration&table=users");
}

/* delete user */
if (isset($_GET['delete_user']) && isset($_GET['user_id'])) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id=" . $_GET['user_id']);
    $stmt->execute();
    header("Location: http://localhost/index.php?page=administration&table=users");
}

/* edit offer desc */
if(isset($_GET['edit_offer_desc']) && isset($_GET['offer_id']) && isset($_POST['edit_offer_desc'])){
    $stmt = $conn->prepare("update offers set detail='".$_POST['edit_offer_desc']."' where id=".$_GET['offer_id']);
    $stmt->execute();
    header("Location: http://localhost/index.php?page=offer_detail&offer_id=".$_GET['offer_id']);
}

/* edit destination desc */
if(isset($_GET['edit_dest_desc']) && isset($_GET['offer_id']) && isset($_POST['edit_dest_desc'])){
    $stmt = $conn->prepare("update pretty_offer set description='".$_POST['edit_dest_desc']."' where id=".$_GET['offer_id']);
    $stmt->execute();
    header("Location: http://localhost/index.php?page=offer_detail&offer_id=".$_GET['offer_id']);
}

/* add comment to dest */
if(isset($_POST['new_comment_hotel_id']) && isset($_POST['new_comment']) && isset($_POST['new_comment_hodnoceni'])){
    $stmt = $conn->prepare("insert into comments (comment, user_id, hotel_id, hodnoceni) values 
        ('".$_POST['new_comment']."', ".$_SESSION['userID'].", ".$_POST['new_comment_hotel_id'].", ".$_POST['new_comment_hodnoceni'].")");
    $stmt->execute();
    header("Location: http://localhost/index.php?page=offer_detail&offer_id=".$_GET['offer_id']);
}

function arrayToXml($xml) {
    require_once 'XML/Serializer.php';
    $options = array("addDecl" => true, "defaultTagName" => "Rezervace", "linebreak" => "", "encoding" => "UTF-8", "rootName" => "Seznam");
    $serializer = new XML_Serializer($options);
    $serializer->serialize($xml);

    $file = 'rezervace.xml';
    $myfile = fopen($file, "w") or die("Unable to open file!");
    $txt = $serializer->getSerializedData();
    fwrite($myfile, $txt);
    fclose($myfile);


    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
}

/* download xml */
if(isset($_GET['download_xml'])){
    $stmt = $conn->prepare("select * from pretty_offer where user_id=".$_SESSION['userID']);
    $stmt->execute();
    arrayToXml($stmt->fetchAll(PDO::FETCH_ASSOC));
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

function cutStringAtLastCommaOrPeriodBeforeN($str, $n)
{
    $rawCutted = substr_replace($str, '', $n);
    $lastComma = strripos($rawCutted, ', ');
    $lastPeriod = strripos($rawCutted, '.');
    if($lastComma > $lastPeriod){
        echo substr_replace(substr_replace($str, '', $n), ' ... ', $lastComma + 1);
    } else {
        echo substr_replace(substr_replace($str, '', $n), ' ... ', $lastPeriod + 1);}
}

?>
<!--TODO
    - nakopčit sorty a searche do admin_dest
    - profile pic
    - výstpuní sestava
-->


<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sunset travel</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Font Awesome & Pixeden Icon Stroke icon font-->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/pe-icon-7-stroke.css">
    <!-- Google fonts - Roboto Condensed & Roboto-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Condensed:700|Roboto:300,400">
    <!-- lightbox-->
    <link rel="stylesheet" href="css/lightbox.min.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.green.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="favicon.png">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

</head>
<body class="home">
<!-- navbar-->
<header class="header">
    <div role="navigation" class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header"><a href="?page=home" class="navbar-brand">Sunset travel</a>
                <div class="navbar-buttons">
                    <button type="button" data-toggle="collapse" data-target=".navbar-collapse"
                            class="navbar-toggle navbar-btn">Menu<i class="fa fa-align-justify"></i></button>
                </div>
            </div>
            <div id="navigation" class="collapse navbar-collapse navbar-right">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="?page=home">Domů</a></li>
                    <li><a href="?page=offers">Naše nabídka</a></li>
                    <li><a href="?page=onas">O nás</a></li>
                    <li><a href="?page=contact">Kontaktuje nás</a></li>

                    <?php
                    if (isset($_SESSION['userID'])) {
                        if ($_SESSION['uRole'] == "Admin") {
                            echo "<li class=\"dropdown\"><a href=\"#\" data-toggle=\"dropdown\" class=\"dropdown-toggle\">Správa <b class=\"caret\"></b></a>
                                <ul class=\"dropdown-menu\">
                                    <li><a href=\"index.php?page=administration&table=offers\">Správa nabídek</a></li>
                                    <li><a href=\"index.php?page=administration&table=destinations\">Správa destinací</a></li>
                                    <li><a href=\"index.php?page=administration&table=users\">Správa uživatelů</a></li>
                                </ul>
                            </li>";
                        }
                        echo "</ul>
                            <a href=\"?page=profile\" class=\"btn navbar-btn btn-white pull-left\">" . $_SESSION['uFirstName'] . " " . $_SESSION['uSurname'] . "</a>";
                    } else {
                        echo "<a href=\"#\" data-toggle=\"modal\" data-target=\"#login-modal\" class=\"btn navbar-btn btn-white pull-left\"><i class=\"fa fa-sign-in\"></i>Přihlášení</a>";
                    }
                    ?>
            </div>
        </div>
    </div>
</header>
<br/><br/>

<!-- *** REGISTRATION MODAL *** -->
<div id="registration-modal" tabindex="-1" role="dialog" aria-labelledby="Register" aria-hidden="true"
     class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">×</button>
                <h4 id="Registration" class="modal-title">Registrace</h4>
            </div>
            <div class="modal-body">
                <form action="index.php?page=home" method="post">
                    <div class="form-group">
                        <input id="reg_FirstName_modal" name="reg_FirstName_modal" type="text"
                               placeholder="Jméno" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input id="reg_Surname_modal" name="reg_Surname_modal" type="text"
                               placeholder="Příjmení" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input id="reg_email_modal" name="reg_email_modal" type="text" placeholder="e-mail"
                               class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input id="reg_login_modal" name="reg_login_modal" type="text"
                               placeholder="Přihlašovací jméno" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input id="reg_password_modal" name="reg_password_modal" type="password"
                               placeholder="Heslo" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input id="reg_password2_modal" name="reg_password2_modal" type="password"
                               placeholder="Heslo podruhé" class="form-control" required>
                    </div>
                    <p class="text-center">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i>Registrovat se
                        </button>
                    </p>
                </form>
                <p class="text-center text-muted">Registrací na tyto stránky vyjadřujete souhlas s obchodními
                    podmínkami, které naleznete
                    <a href="#"><strong>zde</strong></a>.</p>
            </div>
        </div>
    </div>
</div>
<!-- *** REGISTRATION MODAL END *** -->

<!-- *** LOGIN MODAL *** -->
<div id="login-modal" tabindex="-1" role="dialog" class="modal fade">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" class="close">×</button>
                <h4 id="Login" class="modal-title">Přihlášení</h4>
            </div>
            <div class="modal-body">
                <form action="index.php?page=profile" method="post">
                    <div class="form-group">
                        <input id="input_login_modal" name="input_login_modal" type="text"
                               placeholder="Přihlašovací jméno" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <input id="input_password_modal" name="input_password_modal" type="password" placeholder="Heslo"
                               class="form-control" required>
                    </div>
                    <p class="text-center">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-sign-in"></i>Přihlásit se</button>
                    </p>
                </form>
                <p class="text-center text-muted">Ještě u nás nejste zaregistrovaní?</p>
                <p class="text-center text-muted">
                    <a href="#" data-toggle="modal" data-target="#registration-modal" data-dismiss="modal">
                        <strong>Zaregistrujte se zde</strong>
                    </a>
                    , abyste mohli využít všech našich služeb naplno!</p>
            </div>
        </div>
    </div>
</div>

<!-- *** LOGIN MODAL END ***-->
<?php
if (isset($_GET['page'])) {
    switch ($_GET['page']) {
        case 'home':
            include_once 'home.php';
            break;
        case 'onas':
            include_once 'onas.php';
            break;
        case 'contact':
            include_once 'contact.php';
            break;
        case 'profile':
            include_once 'profile.php';
            break;
        case 'offers':
            include_once 'offers.php';
            break;
        case 'offer_detail';
            if (isset($_GET['offer_id'])) {
                $stmt = $conn->prepare("SELECT id FROM offers");
                $stmt->execute();
                $pageLoaded = false;
                while ($result = $stmt->fetch(PDO::FETCH_BOTH)) {
                    if ($result[0] == $_GET['offer_id']) {
                        $pageLoaded = true;
                        include_once 'offer_detail.php';
                        break;
                    }
                }
                if (!$pageLoaded) {
                    include_once '404.php';
                    break;
                }
            }
            break;
        case 'administration':
            include_once 'administration.php';
            break;
        default:
            include_once 'home.php';
            break;
    }
} else {
    include_once 'home.php';
}
?>


<footer class="footer">
    <div class="footer__copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy;2017-2018 Jonáš Urban</p>
                </div>
                <div class="col-md-6">
                    <p class="credit">Template by <a href="https://bootstrapious.com/free-templates" class="external">Bootstrapious
                            templates</a></p>
                    <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Javascript files-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.cookie.js"></script>
<script src="js/lightbox.min.js"></script>
<script src="js/front.js"></script><!-- substitute:livereload -->
<!-- Google Analytics: change UA-XXXXX-X to be your site's ID.-->
<!---->
<script>
    (function (b, o, i, l, e, r) {
        b.GoogleAnalyticsObject = l;
        b[l] || (b[l] =
            function () {
                (b[l].q = b[l].q || []).push(arguments)
            });
        b[l].l = +new Date;
        e = o.createElement(i);
        r = o.getElementsByTagName(i)[0];
        e.src = '//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e, r)
    }(window, document, 'script', 'ga'));
    ga('create', 'UA-XXXXX-X');
    ga('send', 'pageview');
</script>
</body>
</html>

