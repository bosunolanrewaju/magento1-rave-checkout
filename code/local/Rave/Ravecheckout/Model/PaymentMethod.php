<?php

  class Rave_Ravecheckout_Model_PaymentMethod extends Mage_Payment_Model_Method_Abstract {

    protected $_code = 'ravecheckout';

    public function getOrderPlaceRedirectUrl() {
      return Mage::getUrl('ravecheckout/payment/process', array('_secure' => false));
    }

    public function getBaseUrl() {
      // $go_live = $this->getConfigData('go_live');
      return (bool)$go_live ? 'https://ravepay.co/' : 'http://flw-pms-dev.eu-west-1.elasticbeanstalk.com/';
    }

  }
