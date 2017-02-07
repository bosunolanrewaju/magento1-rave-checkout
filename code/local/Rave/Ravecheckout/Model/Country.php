<?php

  class Rave_Ravecheckout_Model_Country
  {
    public function toOptionArray()
    {
      return array(
        array(
          'value' => 'NG',
          'label' => 'NG: Nigeria',
        ),
        array(
          'value' => 'GH',
          'label' => 'GH: Ghana'
        ),
        array(
          'value' => 'KE',
          'label' => 'KE: Kenya'
        ),
        array(
          'value' => 'US',
          'label' => 'All (Worldwide)'
        )
      );
    }
  }
