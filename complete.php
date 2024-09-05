<?php 

require 'vendor/autoload.php';

use Omnipay\Omnipay;

$transactionId = $_POST['transactionId'];
$amount = 100000;

/**
 * Init gateway 
*/
$gateway = Omnipay::create('Sepay');
$gateway->setApiKey('DAQXLMIQYKAR06FNU7WLL4VCBBVSHJ9JSRYKXTIGMHMGVMATUZC9SOVOZQ5A52EN');
$gateway->setBankAccountNumber('0010000000355');
$gateway->setBankName('Vietcombank');

/**
 * Create a purchase request 
*/
$op = $gateway->completePurchase([
    'transactionId' => $transactionId,
    'amount' => $amount, 
    'webhookResponse' => json_decode('{
        "id": 92704,                              
        "gateway":"Vietcombank",                  
        "transactionDate":"2024-07-25 14:02:37",  
        "accountNumber":"0010000000355",             
        "code":null,                              
        "content":"chuyen tien mua iphone",        
        "transferType":"in",                      
        "transferAmount":100000,                 
        "accumulated":19077000,                    
        "subAccount":null,                         
        "referenceCode":"MBVCB.3278907687",       
        "description":"'.$transactionId.'"
    }', true)
])->send();

/**
 * Check if successful 
*/
if($op->isSuccessful()){
    echo $op->getTransactionReference();
}else{
    echo $op->getMessage();
}