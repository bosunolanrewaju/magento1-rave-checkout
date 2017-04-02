<?php
  class Rave_Ravecheckout_Model_Observer {
    /**
     * Exports an order after it is placed
     *
     * @param Varien_Event_Observer $observer observer object
     *
     * @return boolean
     */
    public function setRaveOrder(Varien_Event_Observer $observer) {

      Mage::log('Observer Called!!!');

      $order = $observer->getEvent()->getOrder();
      Mage::getSingleton('ravecheckout/order')
          ->saveLastOrderId($order);

      return true;

    }
  }
