<?php
    $sid = @$_GET['id'];
    $jid = @$_GET['jid'];
    if(isset($_POST['returnbtn']))
    {
        if(isset($_POST['submit_sign']))
        {
            if($_POST['submit_sign'] == "r_int")
            {
                dbquery("UPDATE jelentkezesek SET statusz=1 WHERE jelentkezoID='$sid' AND hirdetesID='$jid'",$connectionx);
                echo '<span class="msg_box">Ez a jelentkező sikeresen interjúra hívható, mostantól megjelennek az elérhetőségei!</span>';
            }
            else if($_POST['submit_sign'] == "r_dec")
            {
                dbquery("UPDATE jelentkezesek SET statusz=2 WHERE jelentkezoID='$sid' AND hirdetesID='$jid'",$connectionx);
                echo '<span class="msg_box">Ez a jelentkező el lett utasítva!</span>';
            }
            else if($_POST['submit_sign'] == "r_get")
            {
                dbquery("UPDATE jelentkezesek SET statusz=3 WHERE jelentkezoID='$sid' AND hirdetesID='$jid'",$connectionx);
                echo '<span class="msg_box">Ez a jelentkező fel lett véve!</span>';
            }
        }
        else echo '<span class="err_msg">Nem választottál ki opciót a visszaigazolásra!</span>';
    }
    $result = dbquery("SELECT * FROM munkavallalok WHERE ID='$sid'",$connectionx);
    $data = mysqli_fetch_assoc($result);
    echo 
    '
        <div id="showprofile">
        <div id="profilediv">
    ';
    $picname = 'mvpic/mv_'.$sid.'.jpg';
    if(file_exists($picname)) echo '<img id="profilepic" src="'.$picname.'" alt="Saját kép">';
    else echo '<img id="profilepic" src="img/empty_user.jpg" alt="Saját kép">';
    echo 
    '
        </div>
        <div id="profilediv2">
        <table>
        <tr><td class="data_1">Név:</td><td class="data_2">'.$data['nev'].'</td></tr>
        <tr><td class="data_1">Életkor:</td><td class="data_2">'.get_age($data['szul_datum']).'</td></tr>
        <tr><td class="data_1">Lakhely:</td><td class="data_2">'.$data['lakhely'].'</td></tr>
        <tr><td class="data_1">Telefonszám:</td><td class="data_2">'.$data['telefonszam'].'</td></tr>
        </table>
        </div>
        <div id="profilediv3">
        <hr>
        <h5><b>Tanulmányok:</b></h5>
        <div id="profilediv4">
    ';
    $sc_result = dbquery("SELECT * FROM tanulmanyok WHERE mvID='$sid'",$connectionx);
    if(mysqli_num_rows($sc_result) == 0) echo '<span class="err_msg">Nincs megadva</span>';
    else
    {
        while($sc_data = mysqli_fetch_assoc($sc_result))
        {
            echo '- '.$sc_data['iskola'].' '.$sc_data['datum'].' <b>('.$sc_data['vegzettseg'].')</b><br>';
        }
    }
    echo 
    '
        </div>
        <hr>
        <h5><b>Munkahelyek:</b></h5>
        <div id="profilediv5">
    ';
    $sc_result = dbquery("SELECT * FROM munkahelyek WHERE mvID='$sid'",$connectionx);
    if(mysqli_num_rows($sc_result) == 0) echo '<span class="err_msg">Nincs megadva</span>';
    else
    {
        while($sc_data = mysqli_fetch_assoc($sc_result))
        {
            echo '- '.$sc_data['munkahely'].' '.$sc_data['datum'].' <b>('.$sc_data['munkakor'].')</b><br>';
        }
    }
    echo 
    '
        </div>
        </div>
        </div>
        <div class="return_sign">
        <h5><b>Visszaigazolás a jelentkezőnek</b></h5><hr>
        <form id="form_return" method="POST" action="index.php?pg=showsn&id='.$sid.'&jid='.$jid.'">
        <input type="radio" id="r_interview" name="submit_sign" value="r_int">
        <label for="r_interview"><span class="job_interview">Interjúra, megbeszélésre hívás</span></label><br>
        <input type="radio" id="r_decline" name="submit_sign" value="r_dec">
        <label for="r_interview"><span class="job_declined">Elutasítás</span></label><br>
        <input type="radio" id="r_get" name="submit_sign" value="r_get">
        <label for="r_interview">Felvétel</label><br>
        <div class="submitholder"><input name="returnbtn" type="submit" value="Jóváhagyás"><br></div>
        </form>
        </div>
    ';
?>