<?php
/**
 *
 * @category   Inovarti
 * @package    Inovarti_Validation
 * @author     Suporte <suporte@inovarti.com.br>
 */

class Inovarti_Validation_AjaxController extends Mage_Core_Controller_Front_Action {

    private function _isEmailRegistered($email) {
        $model = Mage::getModel('customer/customer');
        $model->setWebsiteId(Mage::app()->getStore()->getWebsiteId())->loadByEmail($email);

        if ($model->getId() == NULL) {
            return false;
        }

        return true;
    }

    public function check_emailAction() {
        $validator = new Zend_Validate_EmailAddress();
        $email = $this->getRequest()->getPost('email', false);
        $data = array('result' => 'clean');

        if ($email && $email != '') {
            if (!$validator->isValid($email)) {
                
            } else {
                if ($this->_isEmailRegistered($email)) {
                    $data['result'] = 'exists';
                } else {
                    $data['result'] = 'clean';
                }
            }
        }
        $this->getResponse()->setBody(Zend_Json::encode($data));
    }

    public function check_cpfcnpjAction() {
        $post = $this->getRequest()->getPost();
        if ($post) {
            $cpfcnpj = $this->getRequest()->getPost('cpfcnpj', false);
            $flag = 0;
            $data['result'] = 'clean';
            $cli = Mage::getModel('customer/customer')->getCollection()->addAttributeToFilter('taxvat', array('eq' => $cpfcnpj));
            foreach ($cli as $customer) {
                $dataTaxvat = $customer->getTaxvat();
                if ($dataTaxvat == $cpfcnpj)
                    $flag |= 1;
            }
            if ($flag) {
                $data['result'] = 'exists';
            } else {
                $cpfcnpj = preg_replace("/[^0-9]/", "", $cpfcnpj);
                $cli = Mage::getModel('customer/customer')->getCollection()->addAttributeToFilter('taxvat', array('eq' => $cpfcnpj));
                foreach ($cli as $customer) {
                    $dataTaxvat = $customer->getTaxvat();
                    if ($dataTaxvat == $cpfcnpj)
                        $flag |= 1;
                }
                if ($flag) {
                    $data['result'] = 'exists';
                }
            }
            $this->getResponse()->setBody(Zend_Json::encode($data));
        } else {
            $cpfcnpj = $this->getRequest()->getQuery('cpfcnpj', false);
            $flag = 0;
            $data['result'] = 'clean';
            $cli = Mage::getModel('customer/customer')->getCollection()->addAttributeToFilter('taxvat', array('eq' => $cpfcnpj));
            foreach ($cli as $customer) {
                $dataTaxvat = $customer->getTaxvat();
                if ($dataTaxvat == $cpfcnpj)
                    $flag |= 1;
            }
            if ($flag) {
                $data['result'] = 'exists';
            } else {
                $cpfcnpj = preg_replace("/[^0-9]/", "", $cpfcnpj);
                $cli = Mage::getModel('customer/customer')->getCollection()->addAttributeToFilter('taxvat', array('eq' => $cpfcnpj));
                foreach ($cli as $customer) {
                    $dataTaxvat = $customer->getTaxvat();
                    if ($dataTaxvat == $cpfcnpj)
                        $flag |= 1;
                }
                if ($flag) {
                    $data['result'] = 'exists';
                }
            }
            $this->getResponse()->setBody(Zend_Json::encode($data));
        }
    }

}

?>