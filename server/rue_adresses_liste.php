<?php
require_once 'gdt/cldbgoeland.php';
header("Access-Control-Allow-Origin: *");
$bPrmIdThingOk = false;
if (isset($_GET['idthing'])) {
    $idThing = $_GET['idthing'];
    if (strlen($idThing) < 11) {
        $pattern = '/^\d+$/';
        if (preg_match($pattern, $idThing)) {
            $bPrmIdThingOk = true;
        }
    }
}
if ($bPrmIdThingOk) {
    $dbgo = new DBGoeland();
    $dbgo->queryRetJson2("cn_thistreet_liste_adresses $idThing");
    echo $dbgo->resString;
    unset($dbgo);
} else {
    echo '[]';
}
