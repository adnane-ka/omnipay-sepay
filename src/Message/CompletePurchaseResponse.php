<?php 

namespace Omnipay\Sepay\Message;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        // Check if the transaction was successfully completed based on the response data
        return isset($this->data['status']) && $this->data['status'] === 'completed';
    }

    public function getTransactionReference()
    {
        // Return the transaction reference from the response data
        return isset($this->data['transaction_id']) ? $this->data['transaction_id'] : null;
    }

    public function getMessage()
    {
        // Return any error or success message from the response
        return isset($this->data['message']) ? $this->data['message'] : null;
    }

    public function isPending()
    {
        // Check if the transaction is still pending
        return isset($this->data['status']) && $this->data['status'] === 'pending';
    }

    public function isFailed()
    {
        // Check if the transaction failed
        return isset($this->data['status']) && $this->data['status'] === 'failed';
    }
}