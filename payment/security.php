<?php

define ('HMAC_SHA256', 'sha256');
//define ('SECRET_KEY', '<REPLACE WITH SECRET KEY>');
define ('SECRET_KEY', '9dd9fa871f8d4a2a8d6166ba2220d4263799836e38db45a99f32e22c1c1f7fbc949e06773832414caf55596ca677c7f5db5fba19b6db4d2d8ff824f8de577a54379aad77b31c4b4c8d3d2a29d4cce9fd8721bb658a794bebb1db57fb8e085fa78c045878d98a4c0380c41181380f2c9b7851565c568b492eb40cd3c144750319');
function sign ($params) {
  return signData(buildDataToSign($params), SECRET_KEY);
}

function signData($data, $secretKey) {
    return base64_encode(hash_hmac('sha256', $data, $secretKey, true));
}

function buildDataToSign($params) {
        $signedFieldNames = explode(",",$params["signed_field_names"]);
        foreach ($signedFieldNames as $field) {
           $dataToSign[] = $field . "=" . $params[$field];
        }
        return commaSeparate($dataToSign);
}

function commaSeparate ($dataToSign) {
    return implode(",",$dataToSign);
}

?>
