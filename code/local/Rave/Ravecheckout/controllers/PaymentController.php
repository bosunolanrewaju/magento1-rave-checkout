<?php

  class Rave_Ravecheckout_PaymentController extends Mage_Core_Controller_Front_Action
  {

    public function processAction() {
      $this->loadLayout();
      $block = $this->getLayout()->createBlock('Mage_Core_Block_Template','ravecheckout',array('template' => 'ravecheckout/process.phtml'));
      $this->getLayout()->getBlock('root')->unsetChild('right');
      $this->getLayout()->getBlock('root')->unsetChild('left');
      $this->getLayout()->getBlock('content')->append($block);
      $this->renderLayout();
    }

    public function handlerAction() {
      $paymentMethod = Mage::getModel('ravecheckout/paymentMethod');
      $secretKey = $paymentMethod->getConfigData('secret_key');
      $txRef = $this->getRequest()->get("txRef");

      $txn = json_decode( $this->_fetchTransaction($txRef, $secretKey) );

      if ( ! empty($txn->data) && $this->_is_successful($txn->data) ) {
        $txref = $txn->data->tx_ref;
        $tx_ref_arr = explode('_', $txref);
        $txn_order_id = (int) $tx_ref_arr[1];
        $orderId = Mage::getSingleton('checkout/session')->getLastRealOrderId();
        $order = Mage::getModel('sales/order')->loadByIncrementId($orderId);
        $order_id = (int) $order->getId();
        $order_amount = number_format($order->getGrandTotal(), 2);
        $tx_amount = number_format($txn->data->amount, 2);

        if ( $order_amount !== $tx_amount ) {
          $comment = "<strong>Payment Successful</strong><br>"
                    ."Attention: New order has been placed on hold because of incorrect payment amount. Please, look into it. <br>"
                    ."Amount paid: $tx_amount <br> Order amount: $order_amount <br> Ref:</strong> $txref";
          $order->setState( Mage_Sales_Model_Order::STATE_HOLDED, true, $comment );
        } elseif ($txn_order_id === $order->getId()) {
          $comment = "<strong>Payment Successful</strong><br>"
                    ."Attention: New order has been placed on hold because payment was made for a different order. Please, look into it. <br>"
                    ."Order id paid for: $txn_order_id <br> Current order: $order_id <br> Ref:</strong> $txref";
          $order->setState( Mage_Sales_Model_Order::STATE_HOLDED, true, $comment );
        } else {
          $comment = '<strong>Payment Successful</strong><br><strong>Transaction ref:</strong> ' . $txref;
          $order->setState( Mage_Sales_Model_Order::STATE_PROCESSING, true, $comment );
        }

        $order->save();
        Mage::getSingleton('checkout/session')->unsQuoteId();
        Mage_Core_Controller_Varien_Action::_redirect('checkout/onepage/success', array('_secure' => false));
      } else {
        Mage_Core_Controller_Varien_Action::_redirect('checkout/onepage/failure', array('_secure' => false));
      }

    }

    private function _fetchTransaction($txRef, $secretKey) {
      $paymentMethod = Mage::getSingleton('ravecheckout/paymentMethod');
      $base_url = $paymentMethod->getBaseUrl();

      $URL = $base_url . "flwv3-pug/getpaidx/api/verify";
      $data = http_build_query(array(
        'tx_ref' => $txRef,
        'SECKEY' => $secretKey
      ));

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $URL);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSLVERSION, 3);
      $output = curl_exec($ch);
      $failed = curl_errno($ch);
      $error = curl_error($ch);
      curl_close($ch);

      return ($failed) ? $error : $output;
    }

    private function _is_successful($data) {
      return $data->flwMeta->chargeResponse === '00' || $data->flwMeta->chargeResponse === '0';
    }

  }
