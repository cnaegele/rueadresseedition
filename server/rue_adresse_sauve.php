<?php
require 'gdt/gautentificationf5.php';
require_once '/data/dataweb/GoelandWeb/webservice/employe/clCNWSEmployeSecurite.php';
require_once 'gdt/cldbgoeland.php';
require_once 'gdt/utf8go.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers:  *");
header("Access-Control-Allow-Methods:  POST");
$idCaller = 0;
if (array_key_exists('empid', $_SESSION)) {
    $idCaller = $_SESSION['empid'];
}
if ($idCaller > 0) {
    $pseudoWSEmployeSecurite = new CNWSEmployeSecurite();
    if ($pseudoWSEmployeSecurite->isInGroupe($idCaller, 'RueManager')) {
        $jsonData = file_get_contents('php://input');
        $oData = json_decode($jsonData);
        $idAdresse = $oData->idadresse;
        $idThingRue = $oData->idthingrue;
        $bActif = $oData->bactif;
        $numero = $oData->numero;
        $numeroExtension = $oData->numeroextension;
        $baccesDP = $oData->baccesdp;
        $codePostal = $oData->codepostal;
        $communePostale = $oData->communepostale;
        $extensionCP = $oData->extensioncp;
        $egid = $oData->egid;
        $edid = $oData->edid;
        $coordOE = $oData->coordoe;
        $coordSN = $oData->coordsn;
        $sSql = "cn_ThiStreetBuildingAddress_sauve $idAdresse, $idThingRue, $numero";
        if ($numeroExtension !== '') {
            $sSql .= ",'$numeroExtension'";
        } else {
            $sSql .= ",NULL";
        }
        $sSql .= ",$bActif";
        if ($baccesDP !== '') {
            $sSql .= ",$baccesDP";
        } else {
            $sSql .= ",NULL";
        }
        if ($egid !== '') {
            $sSql .= ",$egid";
        } else {
            $sSql .= ",NULL";
        }
        if ($edid !== '') {
            $sSql .= ",$edid";
        } else {
            $sSql .= ",NULL";
        }
        if ($coordOE !== '') {
            $sSql .= ",$coordOE";
        } else {
            $sSql .= ",NULL";
        }
        if ($coordSN !== '') {
            $sSql .= ",$coordSN";
        } else {
            $sSql .= ",NULL";
        }
        if ($codePostal !== '') {
            $sSql .= ",$codePostal";
        } else {
            $sSql .= ",NULL";
        }
        if ($extensionCP !== '') {
            $sSql .= ",$extensionCP";
        } else {
            $sSql .= ",NULL";
        }
        if ($communePostale !== '') {
            $communePostale = prepareMSSQLvarchar($communePostale);
            $sSql .= ",'$communePostale'";
        } else {
            $sSql .= ",NULL";
        }
        //echo '{"message":"ERREUR: ' . $sSql . '"}';
        $dbgo = new DBGoeland();
        $dbgo->queryRetString($sSql, 'W');
        $messageSP = $dbgo->resString;
        unset($dbgo);
        echo $messageSP;
    } else {
        echo '{"message":"ERREUR GoelandManager requis"}';
    }
} else {
    echo '{"message":"ERREUR athentification F5"}';
}

function prepareMSSQLvarchar($str) {
    $str = str_replace("'", "''", $str);
    $str = utf8go_decode($str);
    return $str;
}


