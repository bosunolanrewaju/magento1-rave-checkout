<?php

  class Rave_Ravecheckout_Helper_Review extends Mage_Core_Helper_Abstract
  {

    public function getRavePlaceOrderButtonTemplate($name, $block) {

      $quote = Mage::getSingleton('checkout/session')->getQuote();
      if ( $quote ) {
        $selectedPaymentMethod = $quote->getPayment()->getMethodInstance()->getCode();
        if ($selectedPaymentMethod == Mage::getModel('ravecheckout/paymentMethod')->getCode()) {
            return $name;
        }
      }

      if ($blockObject = Mage::getSingleton('core/layout')->getBlock($block)) {
        return $blockObject->getTemplate();
      }

      return '';
    }

  }
