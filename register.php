<?php
    if(!isset($_SESSION['UserID'])) // ha nincs bejelentkezve
    {
        if(isset($_POST['r_gomb_1'])) // ha megnyomta a 'Regisztrál' gombot munkavállalóként
        {
            $utype = @$_GET['tp'];
            if(!empty($utype))
            {
                if($utype == 1)
                {
                    $user = escapeshellcmd($_POST['r_nev']);
                    $email = escapeshellcmd($_POST['r_mail']);
                    $pass1 = escapeshellcmd($_POST['r_jelszo']);
                    $birth = escapeshellcmd($_POST['r_szuld']);
                    $result = dbquery("SELECT ID FROM munkavallalok WHERE email='$email'", $connectionx);
                    $result2 = dbquery("SELECT ID FROM munkaadok WHERE email='$email'", $connectionx);
                    if (mysqli_num_rows($result) != 0 || mysqli_num_rows($result2) != 0)
                    {
                        echo
                        '
                            <h4><b>Regisztráció álláskeresőként</b></h4><hr>
                            <div class="c_content">
                            <b><span class="err_msg">A megadott E-Mail cím már regisztrálva van, kérlek adj meg másikat!</span></b><br><br>
                            <form name="form_register_2" method="POST" action="index.php?pg=register&tp=1" onSubmit="return check_registration(1)">
                            <label for="r_nev">Saját neved:</label><br>
                            <input name="r_nev" type="text" value="'.$_POST['r_nev'].'" required><br>
                            <label for="r_mail">E-Mail:</label><br>
                            <input name="r_mail" type="email" value="'.$_POST['r_mail'].'" required><br>
                            <label for="r_jelszo">Jelszó:</label><br>
                            <input name="r_jelszo" type="password" value="'.$_POST['r_jelszo'].'" required minlength="8" maxlength="16"><br>
                            <label for="r_jelszo2">Jelszó megerősítése:</label><br>
                            <input name="r_jelszo2" type="password" value="'.$_POST['r_jelszo2'].'" required minlength="8" maxlength="16"><br>
                            <label for="r_szuld">Születési dátum:</label><br>
                            <input name="r_szuld" type="date" value="'.$_POST['r_szuld'].'" required><br><br>
                            <div class="submitholder"><input name="r_gomb_1" type="submit" value="Regisztráció"></div><br>
                            </form>
                            </div>
                        ';
                    }
                    else
                    {
                        $pass1 = MD5($pass1);
                        $reg_date = date("y:m:d");
                        dbquery("INSERT INTO munkavallalok VALUES(null, 0, '$user', '$email', '$pass1', '$birth','','','$reg_date','$reg_date')", $connectionx);
                        $result = dbquery("SELECT * FROM munkavallalok WHERE nev='$user'", $connectionx);
                        $data = mysqli_fetch_assoc($result);
                        $_SESSION['UserID'] = $data['ID'];
                        $_SESSION['UserType'] = 1;
                        $_SESSION['UserName'] = $user;
                        $_SESSION['UserEmail'] = $email;
                        $_SESSION['UserBirth'] = $birth;
                        $_SESSION['UserHome'] = '';
                        $_SESSION['UserPhone'] = '';
                        header("location: index.php?pg=user");
                        return 1;
                    }
                }
            }
        }
        else if(isset($_POST['r_gomb_2'])) 
        {
            $utype = @$_GET['tp'];
            if(!empty($utype))
            {
                if($utype == 2)
                {
                    $user = escapeshellcmd($_POST['r_nev']);
                    $email = escapeshellcmd($_POST['r_mail']);
                    $pass1 = escapeshellcmd($_POST['r_jelszo']);
                    $tel = escapeshellcmd($_POST['r_tel']);
                    $cname = escapeshellcmd($_POST['r_cnev']);
                    $cpos = escapeshellcmd($_POST['r_hely']);
                    $result2 = dbquery("SELECT ID FROM munkavallalok WHERE email='$email'", $connectionx);
                    $result = dbquery("SELECT ID FROM munkaadok WHERE email='$email'", $connectionx);
                    if (mysqli_num_rows($result) != 0 || mysqli_num_rows($result2) != 0)
                    {
                        echo
                        '
                            <h4><b>Regisztráció munkaadóként</b></h4><hr>
                            <div class="c_content">
                            <b><span class="err_msg">A megadott E-Mail cím már regisztrálva van, kérlek adj meg másikat!</span></b><br><br>
                            <form id="form_register_3" method="POST" action="index.php?pg=register&tp=2" onSubmit="return check_registration(2)">
                            <label for="r_cnev">Cégnév:</label><br>
                            <input name="r_cnev" type="text" value="'.$_POST['r_cnev'].'" required><br>
                            <label for="r_nev">Saját név:</label><br>
                            <input name="r_nev" type="text" value="'.$_POST['r_nev'].'" required><br>
                            <label for="r_mail">E-Mail:</label><br>
                            <input name="r_mail" type="email" value="'.$_POST['r_mail'].'" required><br>
                            <label for="r_jelszo">Jelszó:</label><br>
                            <input name="r_jelszo" type="password" value="'.$_POST['r_jelszo'].'" required minlength="8" maxlength="16"><br>
                            <label for="r_jelszo2">Jelszó megerősítése:</label><br>
                            <input name="r_jelszo2" type="password" value="'.$_POST['r_jelszo2'].'" required minlength="8" maxlength="16"><br>
                            <label for="r_hely">Telephely (város):</label><br>
                            <input name="r_hely" type="search" value="'.$_POST['r_hely'].'" required><br>
                            <label for="r_tel">Telefonszám:</label><br>
                            <input name="r_tel" type="tel" value="'.$_POST['r_tel'].'" required><br><br>
                            <div class="submitholder"><input name="r_gomb_2" type="submit" value="Regisztráció"></div><br>
                            </form>
                            </div>
                        ';
                    }
                    else
                    {
                        $pass1 = MD5($pass1);
                        $reg_date = date("y:m:d");
                        dbquery("INSERT INTO munkaadok VALUES(null, '$user', '$email', '$pass1', '$cname', '$cpos', '$ctel','','$reg_date','$reg_date')", $connectionx);
                        $result = dbquery("SELECT * FROM munkaadok WHERE email='$email'", $connectionx);
                        $data = mysqli_fetch_assoc($result);
                        $_SESSION['UserID'] = $data['ID'];
                        $_SESSION['UserType'] = 2;
                        $_SESSION['UserName'] = $user;
                        $_SESSION['UserEmail'] = $email;
                        $_SESSION['UserCompany'] = $cname;
                        $_SESSION['UserPhone'] = $tel;
                        $_SESSION['UserCompanyPos'] = $data['telephely'];
                        $_SESSION['UserDescription'] = $data['leiras'];
                        header("location: index.php?pg=user");
                        return 1;
                    }
                }
            }
        }
        else
        {
            /*$_POST['user'] = '';
            $_POST['email'] = '';
            $_POST['pass1'] = '';
            $_POST['pass2'] = '';*/
            echo 
            '
                <div id="maincontent">
                <h4><b>Regisztráció</b></h4>
                <hr>
                <div class="c_content">
                <b>Miként szeretnél regisztrálni?</b><br><br>
                <form id="form_register_1" method="POST" action="index.php?pg=register">
                <input name="m_keres" type="button" value="Munkakereső" onclick="m_keresx()">
                <input name="m_ad" type="button" value="Munkaadó" onClick="m_adx()">
                </form><br>
                </div>
                </div>
            ';
        }
    }
    else
    {
        echo
        '
            <div id="maincontent">
            <h4><b>Regisztráció</b></h4>
            <hr>
            <div class="c_content">
            <b>Ez a lap számodra nem elérhető, kijelentkezés után regisztrálhatsz új felhasználót!</b><br><br>
            </div>
            </div>
        ';
    }
?>

<!----------------------------------------------------Javascript------------------------------------------------------------->

<script type="text/javascript">

    function get_age(thevalue) 
    {
        var Bday = +new Date(thevalue);
        return ((Date.now() - Bday) / (31557600000));
    }
    function check_registration(tp)
    {
        if(tp == 1)
        {
            var RegisterForm = document.forms.form_register_2;
            if(RegisterForm.elements.r_jelszo.value != RegisterForm.elements.r_jelszo2.value) 
            {
                alert("A jelszavak nem egyeznek!");
                return false;
            }
            else if(get_age(RegisterForm.elements.r_szuld.value) < 18)
            {
                alert("18 éven aluliak nem regisztrálhatnak!");
                return false;
            }
        }
        else if(tp == 2)
        {
            var RegisterForm = document.forms.form_register_3;
            if(RegisterForm.elements.r_jelszo.value != RegisterForm.elements.r_jelszo2.value) 
            {
                alert("A jelszavak nem egyeznek!");
                return false;
            }
        }
    }
    function m_keresx()
    {
        var stringArray = 
        [
        '<h4><b>Regisztráció álláskeresőként</b></h4><hr>',
        '<div class="c_content">',
        '<form name="form_register_2" method="POST" action="index.php?pg=register&tp=1" onSubmit="return check_registration(1)">',
        '<label for="r_nev">Saját neved:</label><br>',
        '<input name="r_nev" type="text" placeholder="Vezetéknév Keresztnév" required><br>',
        '<label for="r_mail">E-Mail:</label><br>',
        '<input name="r_mail" type="email" placeholder="valami@valami.com" required><br>',
        '<label for="r_jelszo">Jelszó:</label><br>',
        '<input name="r_jelszo" type="password" placeholder="********" required minlength="8" maxlength="16"><br>',
        '<label for="r_jelszo2">Jelszó megerősítése:</label><br>',
        '<input name="r_jelszo2" type="password" placeholder="********" required minlength="8" maxlength="16"><br>',
        '<label for="r_szuld">Születési dátum:</label><br>',
        '<input name="r_szuld" type="date" required><br><br>',
        '<div class="submitholder"><input name="r_gomb_1" type="submit" value="Regisztráció"></div><br>',
        '</form>',
        '</div>'
        ];	
        var cnt = document.getElementById("maincontent");
        cnt.innerHTML = stringArray.join('');
    }
    function m_adx()
    {
        var stringArray = 
        [
        '<h4><b>Regisztráció munkaadóként</b></h4><hr>',
        '<div class="c_content">',
        '<form id="form_register_3" method="POST" action="index.php?pg=register&tp=2" onSubmit="return check_registration(2)">',
        '<label for="r_cnev">Cégnév:</label><br>',
        '<input name="r_cnev" type="text" placeholder="Cég vagy vállalkozó neve" required><br>',
        '<label for="r_nev">Saját név:</label><br>',
        '<input name="r_nev" type="text" placeholder="Vezetéknév Keresztnév" required><br>',
        '<label for="r_mail">E-Mail:</label><br>',
        '<input name="r_mail" type="email" placeholder="valami@valami.com" required><br>',
        '<label for="r_jelszo">Jelszó:</label><br>',
        '<input name="r_jelszo" type="password" placeholder="********" required minlength="8" maxlength="16"><br>',
        '<label for="r_jelszo2">Jelszó megerősítése:</label><br>',
        '<input name="r_jelszo2" type="password" placeholder="********" required minlength="8" maxlength="16"><br>',
        '<label for="r_hely">Telephely (város):</label><br>',
        '<input name="r_hely" type="search" required><br>',
        '<label for="r_tel">Telefonszám:</label><br>',
        '<input name="r_tel" type="tel" required><br><br>',
        '<div class="submitholder"><input name="r_gomb_2" type="submit" value="Regisztráció"></div><br>',
        '</form>',
        '</div>'
        ];	
        var cnt = document.getElementById("maincontent");
        cnt.innerHTML = stringArray.join('');
    }
</script>