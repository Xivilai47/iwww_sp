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
/* pripojeni k DB END*/

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

/* LOGIN FCE END*/

/* LOGIN CALL */
if (isset($_POST['input_login_modal']) && isset($_POST['input_password_modal'])) {
    login($_POST['input_login_modal'], $_POST['input_password_modal']);
}
/* LOGIN CALL END */

/* LOGOUT */
if (isset($_GET['logout'])) {
    unset($_SESSION['userID']);
    unset($_SESSION['uFirstName']);
    unset($_SESSION['uSurname']);
    unset($_SESSION['uEmail']);
    unset($_SESSION['uLogin']);
    unset($_SESSION['uRole']);
}
/* LOGOUT END */

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

/* REGISTRATION END */

/* *** RESERVATION CANCEL *** */
if (isset($_GET['offer_id']) && isset($_GET['cancel'])) {
    $stmt = $conn->prepare("UPDATE offers SET user_ID=NULL WHERE ID=" . $_GET['offer_id']);
    $stmt->execute();
    header("Location: http://localhost/index.php?page=profile");
    die();
}
/* *** RESERVATION CANCEL END *** */

/* add country */
if (isset($_GET['new_coutry']) && isset($_POST['new_country_nazev'])) {
    $stmt = $conn->prepare("INSERT INTO countries (nazev) VALUES ('" . $_POST['new_country_nazev'] . "')");
    $stmt->execute();
    unset($_GET['new_coutry']);
    unset($_POST['new_country_nazev']);
    header("Location: http://localhost/index.php?page=administration&table=destinations");
}
/* add country end */

/* edit country */
if (isset($_GET['edit_country']) && isset($_POST['new_country_name_id']) && isset($_POST['new_country_name'])) {
    $stmt = $conn->prepare("UPDATE countries SET nazev='" . $_POST['new_country_name'] . "' WHERE id=" . $_POST['new_country_name_id']);
    $stmt->execute();
    header("Location: http://localhost/index.php?page=administration&table=destinations");
}
/* edit country end */

/* delete country */
if (isset($_GET['delete_country']) && isset($_GET['country_id'])) {
    $stmt = $conn->prepare("DELETE FROM countries WHERE id=" . $_GET['country_id']);
    $stmt->execute();
    header("Location: http://localhost/index.php?page=administration&table=destinations");
}
/* delete country end */

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Barunka - Multipurpose Bootstrap template by Bootstrapious.com</title>
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
            <div class="navbar-header"><a href="?page=home" class="navbar-brand">ěĚšŠčČřŘžŽýÝáÁíÍéÉúÚůŮ</a>
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
                <form action="index.php?page=home" method="post">
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
            include_once 'offer_detail.php';
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
                    <p>&copy;2017 Your name goes here</p>
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