<?php

  class Rave_Ravecheckout_Model_PaymentMethod extends Mage_Payment_Model_Method_Abstract {

    protected $_code = 'ravecheckout';

    public function getOrderPlaceRedirectUrl() {
      return Mage::getUrl('ravecheckout/payment/process', array('_secure' => false));
    }

  }
