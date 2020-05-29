<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:GET,POST,PUT,DELETE");
header("Content-Type:application/json; charset= utf-8");

$output['datos'] = $json;

echo json_encode($output);