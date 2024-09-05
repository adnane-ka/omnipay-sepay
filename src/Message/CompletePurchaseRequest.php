<?php 

namespace Omnipay\Sepay\Message;

use Omnipay\Common\Message\AbstractRequest;

class CompletePurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        // You typically need the transaction reference or ID to complete the purchase
        return [
            'apiKey' => $this->getParameter('apiKey'),
            'transaction_id' => $this->getTransactionReference(),
        ];
    }

    public function sendData($data)
    {
        // Send a request to Sepay's API to check the transaction status
        $httpResponse = $this->httpClient->post('https://sepay.example.com/transaction/status', null, json_encode($data))->send();

        // Parse the response and return it
        return $this->response = new CompletePurchaseResponse($this, $httpResponse->json());
    }

    public function getTransactionReference()
    {
        // Return the transaction reference parameter
        return $this->getParameter('transactionReference');
    }

    public function setTransactionReference($value)
    {
        // Set the transaction reference parameter
        return $this->setParameter('transactionReference', $value);
    }
}
