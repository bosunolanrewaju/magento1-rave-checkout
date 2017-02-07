# Magento 1.9 Rave Checkout Module

 - **Contributors:** bosunolanrewaju
 - **Tags:** rave, magento 1.9, payment gateway, bank account, credit card, debit card, nigeria, kenya, international, mastercard, visa
 - **Tested with:** PHP 5.6+, Magento CE 1.9.3
 - **Stable tag:** Still in BETA
 - **License:** GPL-3 - see LICENSE.txt

Take payments on your magento 1.9 store using Rave.

Support for:

 - Credit card
 - Debit card
 - Bank account


## Description

Accept Credit card, Debit card and Bank account payment directly on your store with the Rave payment gateway for Magento 1.9.

#### Take Credit card payments easily and directly on your store

Signup for an account [here](https://flutterwave.com)

Rave is available in:

* __Nigeria__
* __Ghana__
* __Kenya__



## Installation


### Magento Connect

Coming Soon.


### Manual Installation

*  Click the Download Zip button and save to your computer.
*  Unpack(Extract) the archive.
*  Copy the content of the __code/local__ directory into your Magento's __app/code/local__ directory.
*  Copy the content of the __design__ directory into your Magento's __app/design__ directory. Only merge this copy, don't replace.
*  Copy file __etc/modules/Rave_Ravecheckout.xml__ into your Magento's __app/etc/modules__ directory.
*  Confirm that module installed correctly:
   Go to __System > Configuration__, then on the left menu, under __ADVANCED__ click __Advanced__. The module should be on the list.

Once you complete the installation, the module will be available in the Store Admin.



### Configure the plugin

Configuration can be done using the Administrator section of your Magento store.

* From the admin dashboard, navigate to __System__ > __Configuration__, then on the left menu __SALES__ > __Payment Methods__.
* Select __Rave Checkout__ from the list of modules.
* Set __Enable__ to __Yes__ and fill the rest of the config form accordingly, then click the orange __Save Config__ to save and activate.
  Note: Public Key and Secret Key are required to activate this module for cart checkout.

## Screenshots ##

![Configuration Screenshot](https://cloud.githubusercontent.com/assets/8383666/22682872/94bc80d4-ed15-11e6-9b9a-b46d811e15f8.png)


### Suggestions / Contributions

For issues and feature request, [click here](https://github.com/bosunolanrewaju/magento1-rave-checkout/issues).
To contribute, fork the repo, add your changes and modifications then create a pull request.


### License

##### GPL-3. See LICENSE.txt
