<?php
  class Rave_Ravecheckout_Model_Session extends Mage_Core_Model_Session_Abstract {

   public function __construct() {
     $namespace = 'ravecheckout';
     $namespace .= '_' . (Mage::app()->getStore()->getWebsite()->getCode());

     $this->init($namespace);
     Mage::dispatchEvent('ravecheckout_session_init', array('ravecheckout_session' => $this));
   }

  }
