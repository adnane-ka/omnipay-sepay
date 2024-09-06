
# Omnipay: Sepay

**Sepay payments gateway for Omnipay payment processing library**

[![Build Status](https://img.shields.io/travis/com/adnane-ka/omnipay-sepay.svg?style=flat-square)](https://travis-ci.com/adnane-ka/omnipay-sepay)
[![Latest Stable Version](https://img.shields.io/packagist/v/adnane-ka/omnipay-sepay.svg?style=flat-square)](https://packagist.org/packages/adnane-ka/omnipay-sepay)
[![Total Downloads](https://img.shields.io/packagist/dt/adnane-ka/omnipay-sepay.svg?style=flat-square)](https://packagist.org/packages/adnane-ka/omnipay-sepay)

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements Tap support for Omnipay.

## Installation
```shell
composer require adnane-ka/omnipay-sepay
```
## Basic Usage
The following gateways are provided by this package:

* Sepay

This package ineteracts with [Sepay's API](https://sepay.vn/lap-trinh-cong-thanh-toan.html). 

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

## Flow

1. Configure gateway.
2. Create a QR image for the operation.
3. Display the QR image for the end-user in a on-site checkout page.
4. Once the operation is accomplished, a webhook should be fired.
5. Receive data from webhook.
6. Complete purchase by comparing / proccessing the received data.

## Example usage
### Configuration

```php
use Omnipay\Omnipay;

$gateway = Omnipay::create('Sepay');
$gateway->setApiKey('YOUR_API_KEY');
$gateway->setBankAccountNumber('YOUR_BANK_ACCOUNT_NUMBER');
$gateway->setBankName('YOUR_BANK_NAME');
```

### Creating a Purchase
```php
$response = $gateway->purchase([
    'amount' => 100000, // the amount in VND
    'checkoutUrl' => 'http://localhost:8000/checkout.php', // the page where the QR image is displayed
    'returnUrl' => 'http://localhost:8000/complete.php', // the URL to return to after the operation is fully proccessed
    'transactionId' => uniqid() // A unique identifier for the operation
])->send();

if ($response->isRedirect()) {
    // The QR code is generated successfully and you're ready to be redirected to checkout
    $response->redirect(); 
} else {
    // An error occured
    echo $response->getMessage();
}
```

### Checkout
```html
<!-- The return URL is going be injected as encoded URL `completeUrl` -->
<form action="<?php echo urldecode($_GET['completeUrl']); ?>" method="post" style="display: flex; flex-direction: column; width:30%;">
    <!-- Display the QR image for the end-user -->
    <img src='<?php echo urldecode($_GET['qrSrc']); ?>'>

    <!-- The transaction ID is received as a query param -->
    <input type="hidden" name="transactionId" value="<?php echo $_GET['transactionId']; ?>">
    <button type="submit">I've Paid, Complete My Order.</button>
</form>
```

### Completing Purchase
When users submit the checkout form after they pay using the displayed QR image, they'll be redirected to `returnUrl` where you'll be proccessing the payment:
```php
$response = $gateway->completePurchase([
    'transactionId' => 'FGJAKANMCHK', // This should be retrieved from request redirect
    'amount' => 100000, // Locate this from your system 
    'webhookResponse' => /*This should be located from the webhook*/ 
    json_decode('{
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
        "description":"FGJAKANMCHK"
    }', true)
])->send();

if($response->isSuccessful()){
    // Payment was successful and charge was captured
    // $response->getData()
    // $response->getTransactionReference() // payment reference
}else{
    // Charge was not captured and payment failed
    // $response->getData()
}
```
## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/adnane-ka/omnipay-tap/issues),
or better yet, fork the library and submit a pull request.