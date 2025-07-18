<?php
$ipAddress = mb_convert_case($_SERVER['SERVER_ADDR'], MB_CASE_LOWER);

switch ($ipAddress) {
//Matomo Site Id for Sandbox Environment
    case '172.31.79.141':
        $matomositeid_json = json_encode("76");
        break;
//Matomo Site Id for Staging Environment
    case '172.31.72.160':
        $matomositeid_json = json_encode("83");
        break;
//Matomo Site Id for Production Environment
    case '172.31.21.221':
        $matomositeid_json = json_encode("87");
        break;
}
echo $matomositeid_json;  
?> 

