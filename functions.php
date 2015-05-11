<?php
function cleanFields($sInput) {
    $sOutput = trim($sInput);
    $sOutput = str_replace(";","",$sOutput);
    $sOutput = str_replace(","," ",$sOutput);
    $sOutput = addslashes($sOutput);
    if(!$sOutput||$sOutput=='') $sOutput = "NULL";
    return $sOutput;
}
function parseText($aRows) {
    foreach($aRows as $sString) {
        //if(!preg_match(STK_NUM_PTN, $sString)) continue;
        if(!preg_match("/[0-9]{2}-[0-9]{2}-[0-9]{3}/", $sString)) continue;
        /* Stock Number */
        $sStkNum = cleanFields(substr($sString, 0, 11));
        $sStkNum = str_replace("-","",$sStkNum);
        $aRet[$sStkNum]['sku'] = $sStkNum;
        /* Description */
        $sDesc = cleanFields(substr($sString, 12, 25));
        $sDesc = DESIGNER." ".$sDesc;
        $aRet[$sStkNum]['name'] = $sDesc;
        /* Supplier Reference */
        $sSupRef = cleanFields(substr($sString, 38, 23));
        $aRet[$sStkNum]['bransom_code'] = $sSupRef;
        /* Price */
        $sPrice = cleanFields(substr($sString, 75, 10));
        $aRet[$sStkNum]['price'] = $sPrice;
        /* Cost */
        $sCost = cleanFields(substr($sString, 86, 6));
        $aRet[$sStkNum]['cost'] = $sCost;
        /* Invoice Date */
        $sInv = substr($sString, 92, 5);
        if(!trim($sInv)) $sInv = "0/0";
        $aRet[$sStkNum]['created_at'] = $sInv;
        /* Quantity */
        $sQty = trim(substr($sString, 108, 6));//hack (1- problem)
        $sQty = ($sQty == "1-") ? $sQty = 0: $sQty;
        $aRet[$sStkNum]['qty'] = $sQty;
    }
    return $aRet;
}
function getCSVString($aFinalArray, $aHeaders, $sHeaderStr, $sDefinedFields) {
    include($sDefinedFields);
    $aRetStrArr[] = $sHeaderStr;//add header line
    foreach($aFinalArray as $iStockNum => $aRowArr) {
        $sTempLineStr = "";
        foreach($aHeaders as $sFieldKey => $sFieldValue) {
            //is this field predefined?
            if(isset($aFieldsDefined[$sFieldKey])) {
                //has it been altered?
                if(array_key_exists($sFieldKey, $_GET)) {
                    $sTempLineStr .= $_GET[$sFieldKey].",";
                } else {
                    $sTempLineStr .= $aFieldsDefined[$sFieldKey].",";
                }
            }
            elseif(isset($aRowArr[$sFieldKey])) { //value from pdf
                $sTempLineStr .= $aRowArr[$sFieldKey].",";
            }
            else {//blank field or custom header value
                if(array_key_exists($sFieldKey, $_GET)) {
                    $sTempLineStr .= $_GET[$sFieldKey].",";
                } else {
                    $sTempLineStr .= ",";
                }
            }
        }//foreach field
        $sTempLineStr = substr($sTempLineStr,0,-1);
        $aRetStrArr[] = $sTempLineStr;
    }//foreach final array

    //var_dump($aRetStrArr); die();
    return implode("\r\n", $aRetStrArr);
}
function getPDFText() {
    include('pdf2txt.php');
    $sText = new PDF2Text();
    $sText->setFilename(DOC);
    $sText->decodePDF();
    $sText =$sText->output();
    $aStrings = explode("\n", $sText);
    return $aStrings;
}
function offerCSV($sCSVStr) {
    //if(headers_sent($file, $line)) {var_dump($file, $line); die();}
    $sCSVName = strtolower(str_replace(" ", "_",DESIGNER).".csv");
    header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename={$sCSVName}");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo trim($sCSVStr);
}
function formatHeaderArr($sHeaderFile) {
    include($sHeaderFile);
    $aTemp = array_flip($aHeaders);
    $iKeys = array_keys($aTemp);
    $sValues = array_fill(0, count($iKeys), null);
    $aHeaders = array_combine($iKeys, $sValues);
    return($aHeaders);
}
function getHeaderString($aHeaders) {
    $sRetStr = "";
    foreach($aHeaders as $sKey => $v) {
        $sRetStr .= $sKey.",";
    }
    $sRetStr = substr($sRetStr, 0, -1);
    return $sRetStr;
}

?>
