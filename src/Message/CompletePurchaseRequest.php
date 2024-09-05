<?php 

namespace Omnipay\Sepay\Message;

use Omnipay\Common\Message\AbstractRequest;

class CompletePurchaseRequest extends AbstractRequest
{
    public function setTransactionId($value)
    {
        return $this->setParameter('transactionId', $value);
    }

    public function setAmount($value)
    {
        return $this->setParameter('amount', $value);
    }

    public function setWebhookResponse($value)
    {
        return $this->setParameter('webhookResponse', $value);
    }

    public function setBankAccountNumber($value)
    {
        return $this->setParameter('bankAccountNumber', $value);
    }

    public function getData()
    {
        return [
            'transactionId' => $this->getParameter('transactionId'),
            'amount' => $this->getParameter('amount'), 
            'webhookResponse' => $this->getParameter('webhookResponse'), 
            'bankAccountNumber' => $this->getParameter('bankAccountNumber')
        ];
    }

    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}