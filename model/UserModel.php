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

class UserModel extends AbstractModel {

    private $avatar = "unlogged";
    private $notifications = [];
    
    public function __construct($config) {
        parent::__construct($config);
        $this->logger = new Logger($config, 'UserModel');
    }    
    
    public function login($login, $password){
        $this->logger->logDebug('login(`' . $login . '`, `' . $password . '`)');
        try {
            if (!empty($login)){
                $sql = 'SELECT password FROM user where login = :login';
                $pwd = $this->executeQuery($sql, array(':login' => $login));
            }
        } catch(PDOException $ex) {
            $this->logger->logError('An Error occured!');
            $this->logger->logError($ex->getMessage());
            throw $ex;
        }

        $this->logger->logDebug('Found pwd: `' . $pwd[0]["password"] . '`');

        if (isset($pwd) && $pwd[0]["password"] === $password){
            $this->logger->logDebug('  return true');
            return TRUE;
        } else {
            $this->logger->logDebug('  return false');
            return FALSE;
        }
    }
    
    public function getUser($login){
        $this->logger->logDebug('getUser(' . $login . ')');
        try {
            if (!empty($login)){
                $sql = 'SELECT * FROM user where login = :login';
                $user = $this->executeQuery($sql, array(':login' => $login));
            }
        } catch(PDOException $ex) {
            $this->logger->logError('An Error occured!');
            $this->logger->logError($ex->getMessage());
            throw $ex;
        }

        return $user;
    }
    
    public function getDefaultShippingAddress($user){
        $this->logger->logDebug('getDefaultShippingAddress(' . $user['id'] . ')');
        try {
            if (!empty($user)){
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
                        'FROM user_address AS adr '.
                            'INNER JOIN user AS usr ON '.
                                'usr.id = adr.user_id '.
                            'AND usr.shipping_address = adr.id '.
                            'INNER JOIN country AS cty ON '.
                                'cty.alpha3 = adr.country_code '.
                        'WHERE adr.user_id = :userId';
                $userAddresses = $this->executeQuery($sql, array(':userId' => $user['id']));
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
    
    public function getAddresses($user){
        $this->logger->logDebug('getAddresses(' . $user['id'] . ')');
        try {
            if (!empty($user)){
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
                        'FROM user_address AS adr '.
                            'INNER JOIN country AS cty ON '.
                                'cty.alpha3 = adr.country_code '.
                        'WHERE user_id = :userId';
                $userAddresses = $this->executeQuery($sql, array(':userId' => $user['id']));
            }
        } catch(PDOException $ex) {
            $this->logger->logError('An Error occured!');
            $this->logger->logError($ex->getMessage());
            throw $ex;
        }

        return $userAddresses;
    }
    
    public function saveAddress($user, $line1, $line2, $line3, $line4, $line5, $postalCode, $city, $country){
        $this->logger->logDebug('saveAddress(' . $user['id'] . ', ' . $line1 . ', ' . $line2 . ', ' . $line3 . ', ' . $line4 . ', ' . $line5 . ', ' . $postalCode . ', ' . $city . ', ' . $country . ')');
        $addressId = -1;
        try {
            if (!empty($user)){
                $this->getDb()->beginTransaction();
                $sql = 'INSERT INTO user_address (user_id, address_line_1, address_line_2, address_line_3, address_line_4, address_line_5, postal_code, city_name, country_code) VALUES (:userId, :addressLine1, :addressLine2, :addressLine3, :addressLine4, :addressLine5, :postalCode, :cityName, :countryCode)';
                $retour = $this->executeSimpleQuery($sql, array(':userId' => $user['id'], 
                                    ':addressLine1' => $line1, 
                                    ':addressLine2' => $line2, 
                                    ':addressLine3' => $line3, 
                                    ':addressLine4' => $line4, 
                                    ':addressLine5' => $line5,
                                    ':postalCode' => $postalCode,
                                    ':cityName' => $city,
                                    ':countryCode' => $country));
                $addressId = $this->getDb()->lastInsertId();
                $sql = 'UPDATE user SET shipping_address = :shippingAddress where id = :userId';
                $retour = $this->executeSimpleQuery($sql, array(':userId' => $user['id'], ':shippingAddress' => $addressId));
                $this->getDb()->commit();
            }
        } catch(PDOException $ex) {
            $this->logger->logError('An Error occured!');
            $this->logger->logError($ex->getMessage());
            throw $ex;
        }

        return $addressId;
    }

    public function getCountries(){
        $this->logger->logDebug('getCountries()');
        try {
            $sql = 'SELECT cty.id, cty.alpha3 AS countryCode, cty.name AS countryName FROM country AS cty ORDER BY countryName';
            $countries = $this->executeQuery($sql, array());
        } catch(PDOException $ex) {
            $this->logger->logError('An Error occured!');
            $this->logger->logError($ex->getMessage());
            throw $ex;
        }

        return $countries;
    }
    
    public function createUser($firstname, $lastname, $email, $login, $password, $avatar){
        $this->logger->logDebug('createUser(' . $firstname . ', ' . $lastname . ', ' . $email . ', ' . $login . ', ' . $password . ', ' . $avatar . ')');
        $retour = FALSE;
        try {
            if (!empty($login)){
                $this->getDb()->beginTransaction();
                $sql = 'INSERT INTO user (firstname, lastname, email, login, password, avatar) VALUES (:firstname, :lastname, :email, :login, :password, :avatar)';
                $retour = $this->executeSimpleQuery($sql, array(':firstname' => $firstname, 
                                    ':lastname' => $lastname, 
                                    ':email' => $email, 
                                    ':login' => $login, 
                                    ':password' => $password, 
                                    ':avatar' => $avatar));
                $this->getDb()->commit();
            }
        } catch(PDOException $ex) {
            $this->logger->logError('An Error occured!');
            $this->logger->logError($ex->getMessage());
            throw $ex;
        }

        return $retour;
    }
}

?>