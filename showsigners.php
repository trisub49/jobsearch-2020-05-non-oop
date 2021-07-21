<?php
    if(!isset($_SESSION['UserID']) || $_SESSION['UserType'] != 2) echo $noenter;
    else
    {
        $jobid = @$_GET['id'];
        $result = dbquery("SELECT *, hirdetesek.feladoID AS fid, jelentkezesek.statusz AS stat FROM jelentkezesek INNER JOIN hirdetesek ON hirdetesek.ID=jelentkezesek.hirdetesID WHERE jelentkezesek.hirdetesID='$jobid'",$connectionx);
        if(!mysqli_num_rows($result)) echo 'Nincsenek még jelentkezők.';
        else
        {
            echo '<h4><b>Jelentkezők kezelése:</b></h4><hr>';
            echo '<div class="joblister">';
            while($data = mysqli_fetch_assoc($result))
            {
                if($_SESSION['UserID'] != $data['fid'])
                {
                    echo $noenter;
                    break;
                }
                else
                {
                    $sid = $data['jelentkezoID'];
                    $result2 = dbquery("SELECT * FROM munkavallalok WHERE ID='$sid'",$connectionx);
                    $data2 = mysqli_fetch_assoc($result2);
                    if($data['stat'] == 0) $status = '<span class="job_waityet">Visszaigazolásra vár</span>';
                    else if($data['stat'] == 1) $status = '<span class="job_interview">Interjúra hívva</span>';
                    else if($data['stat'] == 2) $status = '<span class="job_declined">Elutasítva</span>';
                    echo 
                    '
                        <a class="job_link" href="index.php?pg=showsn&id='.$sid.'&jid='.$data['hirdetesID'].'">
                        <div class="signers_list">
                        <div class="signers_pic">
                    ';
                    $picname = 'mvpic/mv_'.$sid.'.jpg';
                    if(file_exists($picname)) echo '<img class="profilepic_list" src="'.$picname.'" alt="Saját kép">';
                    else echo '<img class="profilepic_list" src="img/empty_user.jpg" alt="Saját kép">';
                    echo 
                    '
                        <h5><b>'.$data2['nev'].'</b></h5> <b>'.$data2['szul_datum'].' ('.get_age($data2['szul_datum']).')</b><br>
                        <div class="data_2">'.$data2['lakhely'].'</div>
                        </div>
                        Állapot: '.$status.'
                        </div>
                        </a>
                    ';
                }
            }
            echo '</div>';
        }
    }
?>