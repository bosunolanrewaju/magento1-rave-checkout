<?php

  class Rave_Ravecheckout_Model_Order {

    protected $myorder = null;

    // Implement this function to save order id in the session
    public function saveLastOrderId($order) {
      Mage::getSingleton('ravecheckout/session')->setLastOrderId($order->getId());
    }

    // Implement this function to get the order saved in the session
    public function getLastOrderId() {
      // For some reasons, magento session is either not persisting data stored in it
      // Or it is non-existent/disabled in your installation.
      //
      // If session were to be available this line works well getting the last_order_id stored
      // in line #8 above.
      //
      // If there is a custom or 3rd party session management tool, you can implement it here
      // by just storing the order id from $this->saveLastOrderId() function and retrieving here.
      //
      // $last_order_id = Mage::getSingleton('ravecheckout/session')->getLastOrderId();
      // return $last_order_id
      //
      // The following implementation fetches the increment id of the last saved order to
      // be used to fetch the order id. This works as you might have noticed/tested.
      //
      // But, it has a drawback: if there are more than one user making orders at the
      // same time. At payment, they all pay for the same order which belongs to the
      // last person to click the Order with Rave button.
      //
      // Remove/Comment this lines if session storage is available:

      $increment_id = Mage::getModel("sales/order")->getCollection()->getLastItem()->getIncrementId();
      return $increment_id;
    }

    // Implement this function to clear order id stored in the session
    // It is called after checkout and payment have been completed
    public function resetOrder() {
      Mage::getSingleton('ravecheckout/session')->unsLastOrderId();
    }

    public function getOrder() {
      $order = new Mage_Sales_Model_Order();
      $id = $this->getLastOrderId();
      // Uncomment if session storage is available
      // $order->loadByAttribute('entity_id', $id);

      // Comment this line if session storage is available
      $order->loadByIncrementId($id);

      return $order;
    }

  }
