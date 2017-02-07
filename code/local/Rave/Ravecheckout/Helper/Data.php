<?php

  class Rave_Ravecheckout_Helper_Data extends Mage_Core_Helper_Abstract
  {
     function getPaymentProcessUrl() {
        return Mage::getUrl('ravecheckout/payment/handler', array('_secure' => false));
    }
  }
