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
      $paymentMethod = Mage::getSingleton('ravecheckout/paymentMethod');
      $secretKey = $paymentMethod->getConfigData('secret_key');
      $txRef = $this->getRequest()->get("txRef");

      $order = Mage::getSingleton('ravecheckout/order')->getOrder();

      $txn = json_decode( $this->_fetchTransaction($txRef, $secretKey) );

      if ( ! empty($txn->data) && $txn->data->status === 'successful' ) {
        $txref = $txn->data->tx_ref;
        $tx_ref_arr = explode('_', $txref);
        $txn_order_id = (int) $tx_ref_arr[1];

        $amount = $order->getGrandTotal();
        $customer = $order->getCustomerEmail();
        $orderId = (int) $order->getId();

        $order_amount = number_format($order->getGrandTotal(), 2);
        $tx_amount = number_format($txn->data->amount, 2);

        if ( $order_amount !== $tx_amount ) {
          $comment = "<strong>Payment Successful</strong><br>"
                    ."Attention: New order has been placed on hold because of incorrect payment amount. Please, look into it. <br>"
                    ."Amount paid: $tx_amount <br> Order amount: $order_amount <br> Ref:</strong> $txref";
          $order->setState( Mage_Sales_Model_Order::STATE_HOLDED, true, $comment );
        } elseif ($txn_order_id !== $orderId) {
          $comment = "<strong>Payment Successful</strong><br>"
                    ."Attention: New order has been placed on hold because payment was made for a different order. Please, look into it. <br>"
                    ."Order id paid for: $txn_order_id <br> Current order: $orderId <br> Ref:</strong> $txref";
          $order->setState( Mage_Sales_Model_Order::STATE_HOLDED, true, $comment );
        } else {
          $comment = '<strong>Payment Successful</strong><br><strong>Transaction ref:</strong> ' . $txref;
          $order->setState( Mage_Sales_Model_Order::STATE_PROCESSING, true, $comment );
        }

        $redirect_url = 'checkout/onepage/success';
      } else {
        $comment = '<strong>Payment Not Verified</strong><br><strong>Transaction ref:</strong> ' . $txRef;
        $comment .= '<br>Attention: New order has been placed on hold because payment couldn\'t be confirmed. Please, verify manually. <br>';
        $order->setState( Mage_Sales_Model_Order::STATE_HOLDED, true, $comment );
        $redirect_url = 'checkout/onepage/failure';
      }

      $order->save();
      Mage::getSingleton('ravecheckout/order')->resetOrder();
      Mage_Core_Controller_Varien_Action::_redirect($redirect_url, array('_secure' => false));
    }

    private function _fetchTransaction($txRef, $secretKey) {
      $paymentMethod = Mage::getSingleton('ravecheckout/paymentMethod');
      $base_url = $paymentMethod->getBaseUrl();

      $URL = $base_url . "tx/verify?tx_ref=$txRef&seckey=$secretKey";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $URL);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSLVERSION, 3);
      $output = curl_exec($ch);
      $info = curl_getinfo($ch);
      $error = curl_error($ch);
      curl_close($ch);

      return (! $output) ? $error : $output;
    }

  }
