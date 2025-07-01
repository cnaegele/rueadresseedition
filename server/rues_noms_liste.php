<?php
require_once 'gdt/cldbgoeland.php';
header("Access-Control-Allow-Origin: *");
$modeLocal = isset($_REQUEST['modelocal'])?$_REQUEST['modelocal']:'ls';
$dbgo = new DBGoeland();
$dbgo->queryRetJson2("cn_thistreet_liste_pour_choix_autocomplete '$modeLocal'");
echo $dbgo->resString;
unset($dbgo);
