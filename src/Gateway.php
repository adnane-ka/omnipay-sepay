<?php 

namespace Omnipay\Sepay;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    /**
     * @return string
    */
    public function getName(){
        return 'Sepay';
    }
    
    /**
     * Create a purchase request
    */
    public function purchase(array $parameters = array()){
        
    }

    /**
     * Complete a purchase request
    */
    public function completePurchase(array $parameters = array()){
        
    }
}