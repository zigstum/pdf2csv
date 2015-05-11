<?php
if(isset($_GET['fileName'])) {
    define('DOC', "uploads/".$_GET['fileName']);
    define('DESIGNER', strtoupper($_GET['des_name_val']));
    define('DEBUG', (int)0);
    include('functions.php');
    /* Get the field headers */
    $aHeaders = formatHeaderArr('headers.php');
    /* Get the defined fields */
    $sDefinedFields = "definedFields.php";
    /* Get the field header string ready for csv output */
    $sHeaderStr = getHeaderString($aHeaders);
    /* Get the txt from the pdf */
    $aRows = getPDFText();
    /* Parse the txt */
    $sParsedText = parseText($aRows);
    //var_dump($sParsedText); die();
    /* Get the CSV string */
    $sCSVStr = getCSVString($sParsedText, $aHeaders, $sHeaderStr, $sDefinedFields);
    /* Is it a preview? */
    if(isset($_GET['preview'])) {
        $sTempFile = "uploads/".substr($_GET['fileName'],0,-3)."csv";
        $res = file_put_contents($sTempFile, $sCSVStr);
        //var_dump($res);
        //die();
    }
    /* Offer the file */
    if(!DEBUG) offerCSV($sCSVStr);
} else {
    die("not allwed.");
}
