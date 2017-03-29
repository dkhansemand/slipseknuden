<?php

    $queryUserLog = $conn->newQuery("SELECT logId, logCode, logMessage, DATE_FORMAT(logDate, '%d/%m %Y %H:%i') AS dateLogged,  logIp, username, userFirstname, userLastname
                                        From log
                                        INNER JOIN users ON logUser = userId
                                        ORDER BY dateLogged DESC");
    if($queryUserLog->execute()){
        $logs = $queryUserLog->fetchAll(PDO::FETCH_ASSOC);
    }
?>

<div id="page-wrapper">
        <div class="container-fluid">

        <!-- Page Heading -->
            <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Kontrolpanel
                    <small>Log</small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="./index.php?p=Dashboard">Kontrolpanel</a>
                    </li>
                        <li class="active">
                        <i class="fa fa-terminal"></i>  <a href="./index.php?p=Log">Log</a>
                    </li>
                    
                </ol>
            </div>
        </div>

        <div class="row">
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">Log - Bruger logins</div>
            <!-- Table -->
            <table class="table table-responsive table-bordered table-hover table-stripped">
                <thead>
                    <th>Kode</th>
                    <th>Besked</th>
                    <th>Dato</th>
                    <th>IP</th>
                    <th>Bruger</th>
                </thead>
                <tbody>
                    <?php
                        foreach($logs as $log){
                        ?>
                        <tr>
                            <td><?=$log['logCode']?></td>
                            <td><?=$log['logMessage']?></td>
                            <td><?=$log['dateLogged']?></td>
                            <td><?=$log['logIp']?></td>
                            <td><?=$log['userFirstname'] . ' ' . $log['userLastname'] . ' (' . $log['username'] . ')'?></td>
                        </tr>
                        <?php
                        }
                    ?>
               </tbody>
            </table>
        </div>
        </div>  
    </div>
</div