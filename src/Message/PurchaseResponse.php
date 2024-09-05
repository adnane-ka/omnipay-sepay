<?php 

namespace Omnipay\Sepay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function isSuccessful()
    {
        return isset($this->data['qrUrl']);
    }

    public function isRedirect()
    {
        return isset($this->data['redirectUrl']);
    }

    public function getRedirectUrl()
    {
        return 
        $this->data['redirectUrl'] 
        . '?qrSrc=' . urlencode($this->data['qrUrl']) 
        .'&completeUrl='. urlencode($this->data['returnUrl'])
        .'&transactionId='. $this->data['transactionId'];
    }
}
