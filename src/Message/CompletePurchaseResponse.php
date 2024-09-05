<?php 

namespace Omnipay\Sepay\Message;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        // @see https://sepay.vn/lap-trinh-cong-thanh-toan.html
        return 
        isset($this->data['webhookResponse']['id'])
        && isset($this->data['webhookResponse']['transferAmount'])
        && $this->data['webhookResponse']['transferAmount'] == $this->data['amount']
        && $this->data['webhookResponse']['accountNumber'] == $this->data['bankAccountNumber']
        && $this->data['webhookResponse']['transferType'] == 'in';
    }

    public function getTransactionReference()
    {
        // @see https://sepay.vn/lap-trinh-cong-thanh-toan.html
        return $this->data['webhookResponse']['referenceCode'];
    }

    public function getMessage()
    {
        return $this->isSuccessful() ?: 'No transaction could be found wiht that Order ID for this Amount.';
    }
}