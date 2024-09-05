<?php 

namespace Omnipay\Sepay\Message;

use Omnipay\Common\Message\AbstractRequest;

class GenerateQrImageRequest extends AbstractRequest
{
    public function setBankAccountNumber($value)
    {
        return $this->setParameter('bankAccountNumber', $value);
    }

    public function setBankName($value)
    {
        return $this->setParameter('bankName', $value);
    }

    public function setCheckoutUrl($value)
    {
        return $this->setParameter('checkoutUrl', $value);
    }

    public function getCheckoutUrl()
    {
        return $this->getParameter('checkoutUrl');
    }

    public function setTransactionId($value)
    {
        return $this->setParameter('transactionId', $value);
    }

    public function getTransactionId()
    {
        return $this->getParameter('transactionId');
    }

    public function setReturnUrl($value)
    {
        return $this->setParameter('returnUrl', $value);
    }

    public function getReturnUrl()
    {
        return $this->getParameter('returnUrl');
    }

    public function getData()
    {
        $data = [
            'amount' => $this->getAmount(),
            'acc' => $this->getParameter('bankAccountNumber'),
            'bank' => $this->getParameter('bankName'),
            'des' => $this->getParameter('transactionId'),
            'template' => 'compact',
        ];
        
        return $data;
    }

    public function sendData($data)
    {
        // Call the API endpoint to create a QR code for the correspending operation
        // @see https://sepay.vn/lap-trinh-cong-thanh-toan.html#qr_dong   
        // Construct the query parameters for the QR code URL
        $qrUrl = sprintf(
            'https://qr.sepay.vn/img?acc=%s&bank=%s&amount=%d&template=%s&des=%s',
            urlencode($data['acc']),
            urlencode($data['bank']),
            intval($data['amount']),
            urlencode($data['template']),
            urlencode($data['des']),
        );

        $httpResponse = $this->httpClient->request('GET', $qrUrl);

        return $this->response = new PurchaseResponse($this, [
            'redirectUrl' => $this->getCheckoutUrl(), 
            'qrUrl' => $qrUrl,
            'returnUrl' => $this->getReturnUrl(),
            'transactionId' => $this->getTransactionId()
        ]);
    }
}