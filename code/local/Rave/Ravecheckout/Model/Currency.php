<?php

  class Rave_Ravecheckout_Model_Currency
  {
    public function toOptionArray()
    {
      return array(
        array(
          'value' => 'NGN',
          'label' => 'NGN (Naira)',
        ),
        array(
          'value' => 'USD',
          'label' => 'USD (Dollar)',
        ),
        array(
          'value' => 'GBP',
          'label' => 'GBP (Pound)',
        ),
        array(
          'value' => 'EUR',
          'label' => 'EUR (Euro)',
        ),
      );
    }
  }
