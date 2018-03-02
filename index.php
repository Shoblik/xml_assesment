<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body onload="">

<div class="container">
    <h2>Striped Rows</h2>
    <p>The .table-striped class adds zebra-stripes to a table:</p>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Creditor</th>
            <th>Date</th>
            <th>Outstanding Balance</th>
            <th>Monthly Payment</th>
            <th>Account Type</th>
        </tr>
        </thead>
        <tbody id="newData">
<!--        <tr>-->
<!--            <td id="name">Simon</td>-->
<!--            <td>2/26/1997</td>-->
<!--            <td>19087</td>-->
<!--            <td>498</td>-->
<!--            <td>arbitrary</td>-->
<!--        </tr>-->

        </tbody>
    </table>
</div>
</body>
</html>

<?php

/**
 * Created by PhpStorm.
 * User: shobl
 * Date: 3/2/2018
 * Time: 10:02 AM
 */
$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><REQUEST_GROUP MISMOVersionID="2.3.1"></REQUEST_GROUP>');
$reqParty = $xml->addChild('REQUESTING_PARTY');
$reqParty->addAttribute('_Name', 'ACG Funding');
$reqParty->addAttribute('_PostalCode', '91748');
$reqParty->addAttribute('_State', 'CA');
$reqParty->addAttribute('_City', 'City of Industry');
$reqParty->addAttribute('_StreetAddress', '1661 Hanover Road Suite 216');

$recParty = $xml->addChild('RECEIVING_PARTY ');
$recParty->addAttribute('_PostalCode', "21804");
$recParty->addAttribute('_State', "MD");
$recParty->addAttribute('_City', "Salisbury");
$recParty->addAttribute('_StreetAddress', "16892 Bolsa Chica Street 201");
$recParty->addAttribute('_Name', "Credit Plus");
$recParty->addAttribute('_Identifier', "AV");

$subParty = $xml->addChild('SUBMITTING_PARTY');
$subParty->addAttribute('_PostalCode', '92649');
$subParty->addAttribute('_State', 'CA');
$subParty->addAttribute('_City', 'Huntington Beach');
$subParty->addAttribute('_StreetAddress', '16892 Bolsa Chica Street 201');
$subParty->addAttribute('_Name', 'BeSmartee');
$subParty->addAttribute('_Identifier', 'BeSmartee07272015');
$subParty->addAttribute('loginAccountPassword', '263nx848');
$subParty->addAttribute('LoginAccountIdentifier', 'besmartee');

$req = $xml->addChild('REQUEST');
$req->addAttribute('LoginAccountPassword', 'CHECKm@te1');
$req->addAttribute('LoginAccountIdentifier', 'TNGUYEN3');
$req->addAttribute('InternalAccountIdentifier', '');
$req->addAttribute('RequestDatetime', '2017-02-26T09:20:59');

$requestData = $req->addChild('REQUEST_DATA');

$creditRequest = $requestData->addChild('CREDIT_REQUEST');
$creditRequest->addChild('MISMOVersionID', '2.3.1');
$creditRequest->addChild('LenderCaseIdentifier', 'LME8BW68');
$creditRequest->addChild('RequestingPartyRequestedByName', 'Benson Pang');

$creditReqData = $creditRequest->addChild('CREDIT_REQUEST_DATA');
$creditReqData->addAttribute('CreditRequestDateTime', '2017-02-26T09:20:59');
$creditReqData->addAttribute('CreditRequestType', 'Individual');
$creditReqData->addAttribute('CreditReportType', 'Merge');
$creditReqData->addAttribute('CreditReportRequestActionType', 'Submit');
$creditReqData->addAttribute('BorrowerID', 'Borrower');
$creditReqData->addAttribute('CreditRequestID', 'CreditRequest1');

$creditRepo = $creditReqData->addChild('CREDIT_REPOSITORY_INCLUDED');
$creditRepo->addAttribute('_TransUnionIndicator', 'Y');
$creditRepo->addAttribute('_ExperianIndicator', 'Y');
$creditRepo->addAttribute('_EquifaxIndicator', 'Y');

$loanApp = $creditRequest->addChild('LOAN_APPLICATION');

$borrower = $loanApp->addChild('BORROWER');
$borrower->addAttribute('BorrowerID', 'Borrower');
$borrower->addAttribute('_PrintPositionType', 'Borrower');
$borrower->addAttribute('_SSN', '123456789');
$borrower->addAttribute('_HomeTelephoneNumber', '714-235-7114');
$borrower->addAttribute('_BirthDate', '1999-01-01');
$borrower->addAttribute('_LastName', 'Testcase');
$borrower->addAttribute('_FirstName', 'Tim');

$residence = $borrower->addChild('_RESIDENCE');
$residence->addAttribute('_PostalCode', '92649');
$residence->addAttribute('_State', 'CA');
$residence->addAttribute('_City', 'Huntington Beach');
$residence->addAttribute('_StreetAddress', '4053 Aladdin Dr');
$residence->addAttribute('BorrowerResidencyType', 'Current');

$xml_str = $xml->saveXML('./test.xml');

$ch = curl_init('https://credit.meridianlink.c om/inetapi/AU/get_credit_repor t.aspx');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_str);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);


$response = simplexml_load_file(('./response.xml'));

$creditorNodes = $response->xpath('//CREDIT_LIABILITY/_CREDITOR');
$creditorCount = count($creditorNodes);

    for ($i=0; $i < $creditorCount; $i++) {
        $name = $creditorNodes[$i]['_Name'];
        ?> <script>
            tr = document.createElement('tr');
            //name
            td = document.createElement('td');
            td.innerText = '<?php echo $name; ?>';
            tr.appendChild(td);
            document.querySelector('#newData').appendChild(tr);
            //Date

        </script>
        <?php
    }


$simon = 'lightBlue';

?>

