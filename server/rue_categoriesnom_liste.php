<?php
require_once 'gdt/cldbgoeland.php';
header("Access-Control-Allow-Origin: *");
$dbgo = new DBGoeland();
$dbgo->queryRetJson2('cn_dicostreetcategname_liste');
echo $dbgo->resString;
unset($dbgo);
