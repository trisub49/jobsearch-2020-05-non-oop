<?php
    $isregistered;
    $jobid = @$_GET['id'];
    $result = dbquery("SELECT *, kategoriak.kategoria_nev AS kat FROM hirdetesek INNER JOIN kategoriak ON hirdetesek.kategoria=kategoriak.ID INNER JOIN munkaadok ON munkaadok.ID = hirdetesek.feladoID WHERE hirdetesek.ID=$jobid",$connectionx);
    if(mysqli_num_rows($result) == 0) echo '<div class="msg_box">A kért oldal nem létezik!</div>';
    else
    {
        $userid = @$_SESSION['UserID'];
        $isregistered = dbquery("SELECT * FROM jelentkezesek WHERE hirdetesID='$jobid' AND jelentkezoID='$userid'",$connectionx);
        $buttontext = "Jelentkezés";
        if(isset($_POST['addme']))
        {
            if(isset($_SESSION['UserID']))
            {
                if($_SESSION['UserType'] != 1) echo '<div class="msg_box"><span class="err_msg">Csak munkakeresőként jelentkezhetsz állásra!</span></div>';
                else
                {
                    $isregistered = dbquery("SELECT * FROM jelentkezesek WHERE hirdetesID='$jobid' AND jelentkezoID='$userid'",$connectionx);
                    if(mysqli_num_rows($isregistered) == 0)
                    {
                        dbquery("INSERT INTO jelentkezesek VALUES(null,'$jobid','$userid',0)",$connectionx);
                        echo
                        '
                            <div class="msg_box">Sikeres jelentkezés.<br>
                            Ha vissza szeretnéd vonni, kattints a "Visszavonás" gombra!
                            </div>
                        ';
                        $buttontext = 'Visszavonás';
                    }
                    else
                    {
                        dbquery("DELETE FROM jelentkezesek WHERE jelentkezoID='$userid' AND hirdetesID='$jobid'",$connectionx);
                        echo '<div class="msg_box">Visszavontad a jelentkezésed!</div>';
                        $buttontext = "Jelentkezés";                 
                    }
                }
            }
            else echo '<div class="msg_box"><span class="err_msg">Állásra jelentkezéshez előbb be kell jelentkezned!</span></div>';
        }
        else if(isset($_POST['delete']))
        {
            echo 'eyyyeee';
        }
        if(!isset($_SESSION['UserID'])) $buttontext = "Jelentkezés";
        else
        {
            $isregistered = dbquery("SELECT * FROM jelentkezesek WHERE hirdetesID='$jobid' AND jelentkezoID='$userid'",$connectionx);
            if(mysqli_num_rows($isregistered) != 0) $buttontext = "Visszavonás";
        }
        $data = mysqli_fetch_assoc($result);
        echo
        '
            <div class="job_all_2">
            <div class="job_header">
            <span class="job_name">'.$data['munkakor'].'</span>
            <div class="job_regtime">'.$data['fel_datum'].'</div>
            </div>
            <div class="job_content">
            <table class="job_table d-none d-sm-block">
            <tr><td class="icono-folder iex"</td><td class="job_bla">Feladó:</td><td class="job_company">'.$data['cegnev'].'</td></tr>
            <tr><td class="icono-list iex"</td><td class="job_bla">Kategória:</td><td class="job_category">'.$data['kat'].'</td></tr>
            <tr><td class="icono-locationArrow iex"</td><td class="job_bla">Munkavégzés helye:</td><td class="job_category">'.$data['hely'].'</td></tr>
            <tr><td class="icono-exclamationCircle iex"</td><td class="job_bla">Jelentkezési határidő:</td><td class="job_deadline">'.$data['hatarido'].'</td></tr>
            </table>
            <table class="d-block d-sm-none">
            <tr><td class="icono-folder iex"</td><td class="job_company">'.$data['cegnev'].'</td></tr>
            <tr><td class="icono-list iex"></td><td class="job_category">'.$data['kat'].'</td></tr>
            <tr><td class="icono-locationArrow iex"></td><td class="job_category">'.$data['hely'].'</td></tr>
            <tr><td class="icono-exclamationCircle iex"></td><td class="job_deadline">'.$data['hatarido'].'</td></tr>
            </table>
            </div>
            <div class="job_desc">
            <h5><b>A munkáról:</b></h5>
            <div class="job_desc_2">'.nl2br($data['hirdetes_szoveg']).'</div>
        ';
        if(isset($_SESSION['UserID']))
        {
            $data2 = mysqli_fetch_assoc($isregistered);
            if($_SESSION['UserType'] == 1 && $data2['statusz'] != 2)
            {
                echo
                '
                    <form id="form_add_registers" method="POST" action="index.php?pg=showjob&id='.$jobid.'">
                    <div class="submitholder"><input name="addme" type="submit" value='.$buttontext.'><br><br></div>
                ';
            }
            else if($_SESSION['UserType'] == 2)
            {
                $result3 = dbquery("SELECT * FROM hirdetesek WHERE ID='$jobid'",$connectionx);
                $data3 = mysqli_fetch_assoc($result3);
                if($_SESSION['UserID'] == $data3['feladoID'])
                {
                    echo
                    '
                        <br>
                        <form id="edit_job" method="POST" action="index.php?pg=editjob&id='.$jobid.'">
                        <div class="submitholder"><input name="edit" type="submit" value="Szerkesztés"></div>
                        </form>
                        <br>
                    ';
                }
            }
        }
        echo '</div>';
        if(!empty($data['leiras']))
        {
            echo
            '
                <div class="comp_desc">
                <h5><b>A cégről: </b></h5>
                '.$data['leiras'].'
                </div>
            ';
        }
        echo '</div>';
    }
?>