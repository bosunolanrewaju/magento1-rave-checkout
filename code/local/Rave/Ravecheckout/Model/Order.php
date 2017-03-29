<?php

  class Rave_Ravecheckout_Model_Order {

    protected $myorder = null;

    public function saveLastOrderId($order) {
      Mage::getSingleton('ravecheckout/session')->setLastOrderId($order->getId());
    }

    public function getLastOrderId() {
      $last_order_id = Mage::getSingleton('ravecheckout/session')->getLastOrderId();
      return $last_order_id;
    }

    public function resetOrder() {
      Mage::getSingleton('ravecheckout/session')->unsLastOrderId();
    }

    public function getOrder() {
      $order = new Mage_Sales_Model_Order();
      $id = $this->getLastOrderId();
      $order->loadByAttribute('entity_id', $id);

      return $order;
    }

  }
