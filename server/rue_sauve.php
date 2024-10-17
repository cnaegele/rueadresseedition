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
        //echo $jsonData;
        $oData = json_decode($jsonData);
        $json_error = json_last_error();
        if ($json_error == JSON_ERROR_NONE) {
            $idThing = $oData->idthing;
            $idVille = $oData->idville;
            $idTypeRue = $oData->idtyperue;
            $idCategorieNom = $oData->idcategorienom;
            $bpublic = $oData->bpublic;
            $article = $oData->article;
            $prenom = $oData->prenom;
            $nom = $oData->nom;
            $nomLong = $oData->nomlong;
            $nomCourt = $oData->nomcourt;
            $codeRue = $oData->coderue;
            $estrid = $oData->estrid;
            $esid = $oData->esid;
            $commentaire = $oData->commentaire;
            $dateDecisionMuni = $oData->datedecisionmuni;
            $coordMinOE = $oData->coordminoe;
            $coordMinSN = $oData->coordminsn;
            $coordMaxOE = $oData->coordmaxoe;
            $coordMaxSN = $oData->coordmaxsn;

            $sSql = "cn_ThiStreet_sauve $idThing, $idVille, $idTypeRue, $idCategorieNom";
            if ($bpublic !== '') {
                $sSql .= ",$bpublic";
            } else {
                $sSql .= ",NULL";
            }
            if ($article !== '') {
                $article = prepareMSSQLvarchar($article);
                $sSql .= ",'$article'";
            } else {
                $sSql .= ",NULL";
            }
            if ($prenom !== '') {
                $prenom = prepareMSSQLvarchar($prenom);
                $sSql .= ",'$prenom'";
            } else {
                $sSql .= ",NULL";
            }
            $nom = prepareMSSQLvarchar($nom);
            $nomLong = prepareMSSQLvarchar($nomLong);
            $nomCourt = prepareMSSQLvarchar($nomCourt);
            $sSql .= ",'$nom','$nomLong','$nomCourt'";
            if ($codeRue !== '') {
                $sSql .= ",$codeRue";
            } else {
                $sSql .= ",NULL";
            }
            if ($estrid !== '') {
                $sSql .= ",$estrid";
            } else {
                $sSql .= ",NULL";
            }
            if ($esid !== '') {
                $sSql .= ",$esid";
            } else {
                $sSql .= ",NULL";
            }
            if ($dateDecisionMuni !== '') {
                $sSql .= ",'$dateDecisionMuni-01-01'";
            } else {
                $sSql .= ",NULL";
            }
            if ($commentaire !== '') {
                $commentaire = prepareMSSQLvarchar($commentaire);
                $sSql .= ",'$commentaire'";
            } else {
                $sSql .= ",NULL";
            }
            if ($coordMinOE !== '' && $coordMinSN !== '' && $coordMaxOE !== '' && $coordMaxSN !== '') {
                $sSql .= ",$coordMinOE,$coordMinSN,$coordMaxOE,$coordMaxSN";
            } else {
                $sSql .= ",NULL,NULL,NULL,NULL";
            }
            $sSql .= ",$idCaller";

            //echo '{"message":"ERREUR: ' . $sSql . '"}';
            $dbgo = new DBGoeland();
            $dbgo->queryRetString($sSql, 'W');
            $messageSP = $dbgo->resString;
            unset($dbgo);
            echo $messageSP;
        } else {
            switch ($json_error) {
                case JSON_ERROR_DEPTH:
                    $msg_json_error = 'Maximum stack depth exceeded';
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    $msg_json_error = 'Underflow or the modes mismatch';
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    $msg_json_error = 'Unexpected control character found';
                    break;
                case JSON_ERROR_SYNTAX:
                    $msg_json_error = 'Syntax error, malformed JSON';
                    break;
                case JSON_ERROR_UTF8:
                    $msg_json_error = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                    break;
                default:
                    $msg_json_error = 'Unknown error';
                    break;
            }
            echo '{"message":"ERREUR php json: ' . $msg_json_error . '"}';
        }
    } else {
        echo '{"message":"ERREUR RueManager requis"}';
    }
} else {
    echo '{"message":"ERREUR athentification F5"}';
}

function prepareMSSQLvarchar($str) {
    $str = str_replace("'", "''", $str);
    $str = utf8go_decode($str);
    return $str;
}
