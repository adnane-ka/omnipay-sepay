<?php 

namespace Omnipay\Sepay;

use Omnipay\Common\AbstractGateway;
use Omnipay\Sepay\Message\GenerateQrImageRequest; 
use Omnipay\Sepay\Message\CompletePurchaseRequest; 

class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Sepay';
    }

    public function getDefaultParameters()
    {
        return [
            'apiKey' => '',
            'bankAccountNumber' => '',
            'bankName' => ''
        ];
    }

    public function setApiKey($value)
    {
        return $this->setParameter('apiKey', $value);
    }

    public function getApiKey()
    {
        return $this->getParameter('apiKey');
    }

    public function setBankAccountNumber($value)
    {
        return $this->setParameter('bankAccountNumber', $value);
    }

    public function getBankAccountNumber()
    {
        return $this->getParameter('bankAccountNumber');
    }

    public function setBankName($value)
    {
        return $this->setParameter('bankName', $value);
    }

    public function getBankName()
    {
        return $this->getParameter('bankName');
    }

    public function purchase(array $parameters = [])
    {
        return $this->createRequest(GenerateQrImageRequest::class, $parameters);
    }

    public function completePurchase(array $parameters = [])
    {
        return $this->createRequest(CompletePurchaseRequest::class, $parameters);
    }
}