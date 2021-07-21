<?php
    if(!isset($_SESSION['UserID'])) echo $noenter;
    else
    {
        $userid = $_SESSION['UserID'];
        if($_SESSION['UserType'] == 1)
        {
            echo '<h4><b>Beadott jelentkezéseim</b></h4><hr>';
            echo '<div class="sign_background"><span class="job_waityet">Még visszaigazolásra vár:</span>';
            $result_wait = "SELECT * FROM jelentkezesek INNER JOIN hirdetesek ON hirdetesek.ID = jelentkezesek.hirdetesID INNER JOIN munkaadok ON munkaadok.ID = hirdetesek.feladoID WHERE jelentkezesek.jelentkezoID = '$userid' AND jelentkezesek.statusz = 0";
            $result = dbquery($result_wait,$connectionx);
            if(!mysqli_num_rows($result)) echo '<div class="joblister">Ez a lista üres.</div>';
            else
            {
                echo '<div class="joblister"><table class="jobs_table">';
                while($data = mysqli_fetch_assoc($result))
                {
                    $jobname = $data['munkakor'];
                    $jobcomp = $data['cegnev'];
                    echo '
                    <tr><td class="jobs_td"><a class="job_link_2" href="index.php?pg=showjob&id='.$data['hirdetesID'].'">'.$jobname.'</a></td><td class="jobs_td">'.$jobcomp.'</td><td class="jobs_td">'.$data['hely'].'</td></tr>
                    ';
                } 
                echo '</table></div>';
            }
            echo '<span class="job_interview">Interjúra hívtak/hívnak:</span>';
            $result_interview = "SELECT * FROM jelentkezesek INNER JOIN hirdetesek ON hirdetesek.ID = jelentkezesek.hirdetesID INNER JOIN munkaadok ON munkaadok.ID = hirdetesek.feladoID WHERE jelentkezesek.jelentkezoID = '$userid' AND jelentkezesek.statusz = 1";
            $result = dbquery($result_interview,$connectionx);
            if(!mysqli_num_rows($result)) echo '<div class="joblister">Ez a lista üres.</div>';
            else
            {
                echo '<div class="joblister"><table class="jobs_table">';
                while($data = mysqli_fetch_assoc($result))
                {
                    $jobname = $data['munkakor'];
                    $jobcomp = $data['cegnev'];
                    echo '
                    <tr><td class="jobs_td"><a class="job_link_2" href="index.php?pg=showjob&id='.$data['hirdetesID'].'">'.$jobname.'</a></td><td class="jobs_td">'.$jobcomp.'</td><td class="jobs_td">'.$data['hely'].'</td></tr>
                    '; 
                } 
                echo '</table></div>';
            }
            echo '<span class="job_declined">Mást választottak, jelentkezésedet elutasították:</span>';
            $result_nosuccess = "SELECT * FROM jelentkezesek INNER JOIN hirdetesek ON hirdetesek.ID = jelentkezesek.hirdetesID INNER JOIN munkaadok ON munkaadok.ID = hirdetesek.feladoID WHERE jelentkezesek.jelentkezoID = '$userid' AND jelentkezesek.statusz = 2";
            $result = dbquery($result_nosuccess,$connectionx);
            if(!mysqli_num_rows($result)) echo '<div class="joblister">Ez a lista üres.</div>';
            else
            {
                echo '<div class="joblister"><table class="jobs_table">';
                while($data = mysqli_fetch_assoc($result))
                {
                    $jobname = $data['munkakor'];
                    $jobcomp = $data['cegnev'];
                    echo '
                    <tr><td class="jobs_td"><a class="job_link_2" href="index.php?pg=showjob&id='.$data['hirdetesID'].'">'.$jobname.'</a></td><td class="jobs_td">'.$jobcomp.'</td><td class="jobs_td">'.$data['hely'].'</td></tr>
                    ';
                } 
                echo '</table></div>';
            }
            echo '</div>';
        }
        else if($_SESSION['UserType'] == 2)
        {
            echo '<h4><b>Hirdetéseid</b></h4><hr>';
            $result = dbquery("SELECT * FROM hirdetesek WHERE feladoID='$userid'",$connectionx);
            echo '<div class="sign_background"><h5><b>Feladott hirdetések:</b></h5>';
            if(!mysqli_num_rows($result)) echo '<div class="joblister">Ez a lista üres.</div>';
            else
            {
                echo '
                    <div class="joblister"><table class="jobs_table">
                    <tr><th class="jobs_td">Munkakör</th><th class="jobs_td">Határidő</th><th class="jobs_td">Jelentkezők</th></tr>
                    ';
                while($data = mysqli_fetch_assoc($result))
                {
                    $id = $data['ID'];
                    $result_signers = dbquery("SELECT * FROM jelentkezesek WHERE hirdetesID='$id'",$connectionx);
                    $jobname = $data['munkakor'];
                    $jobdeadline = $data['hatarido'];
                    $signers = mysqli_num_rows($result_signers);
                    echo '
                    <tr><td class="jobs_td"><a class="job_link_2" href="index.php?pg=showjob&id='.$data['ID'].'">'.$jobname.'</a></td><td class="jobs_td">'.$jobdeadline.'</td><td class="jobs_td"><a class="job_link_2" href="index.php?pg=showsigners&id='.$data['ID'].'">'.$signers.' fő</a></td></tr>
                    ';
                }
                echo '</table></div>';
            }
            echo '
                </div><hr>
                <form id="form_add_job" method="POST" action="index.php?pg=addjob">
                <div class="submitholder"><input name="addjob" type="submit" value="Hirdetésfeladás"><br><br></div>
                ';
        }
    }
?>