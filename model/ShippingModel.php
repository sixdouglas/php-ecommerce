<?php
/*
 * Copyright 2018 the original author or authors.
 *
 * Licensed under the Apache License, Version 2.0 (the 'License');
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an 'AS IS' BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once('AbstractModel.php');

class ShippingModel extends AbstractModel {

    public function __construct($config) {
        parent::__construct($config);
        $this->logger = new Logger($config, 'ShippingModel');
    }

    public function getHomeDeliveryFees($address, $cart){
        // Some real world logic can be implemented here
        // but not in this sample application :)
        return 6;
    }

    public function saveShippingAddressInOrder($addressId, $orderId){
        $this->logger->logDebug('saveShippingAddressInOrder(' . $addressId . ', ' . $orderId . ')');
        $retour = -1;
        try {
            if (!empty($orderId) && !empty($addressId)){
                $this->getDb()->beginTransaction();
                $sql = 'INSERT INTO order_address (address_line_1, address_line_2, address_line_3, address_line_4, address_line_5, postal_code, city_name, country_code, order_id, `type`) ' .
                ' SELECT address_line_1, address_line_2, address_line_3, address_line_4, address_line_5, postal_code, city_name, country_code, :orderId, :type FROM user_address WHERE id = :addressId';
                $retour = $this->executeSimpleQuery($sql, array(':orderId' => $orderId, 
                                    ':type' => 'SHIPPING',
                                    ':addressId' => $addressId));
                $this->getDb()->commit();
            }
        } catch(PDOException $ex) {
            $this->logger->logError('An Error occured!');
            $this->logger->logError($ex->getMessage());
            throw $ex;
        }

        return $retour;
    }
    
    public function getCartShippingAddress($orderId){
        $this->logger->logDebug('getCartShippingAddress(' . $orderId . ')');
        try {
            if (!empty($orderId)){
                $sql = 'SELECT adr.id AS addressId, '.
                                'adr.address_line_1 AS line1, '.
                                'adr.address_line_2 AS line2, '.
                                'adr.address_line_3 AS line3, ' .
                                'adr.address_line_4 AS line4, '.
                                'adr.address_line_5 AS line5, '.
                                'adr.postal_code AS postalCode, '.
                                'adr.city_name AS cityName, ' .
                                'adr.country_code AS countryCode, '.
                                'cty.name AS countryName ' .
                        'FROM order_address AS adr '.
                            'INNER JOIN country AS cty ON '.
                                'cty.alpha3 = adr.country_code '.
                        'WHERE adr.order_id = :orderId ' .
                        'AND   adr.`type` = \'SHIPPING\'';
                $userAddresses = $this->executeQuery($sql, array(':orderId' => $orderId));
            }
        } catch(PDOException $ex) {
            $this->logger->logError('An Error occured!');
            $this->logger->logError($ex->getMessage());
            throw $ex;
        }
        if (!empty($userAddresses)){
            return $userAddresses[0];
        } else {
            return NULL;
        }
    }
}

?>