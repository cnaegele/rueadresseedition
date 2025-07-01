<?php
require_once 'gdt/cldbgoeland.php';
header("Access-Control-Allow-Origin: *");
$dbgo = new DBGoeland();
$dbgo->queryRetJson2('cn_thicity_liste_pour_rue');
echo $dbgo->resString;
unset($dbgo);
