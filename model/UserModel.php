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
        $this->logger = new Logger('UserModel');
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
    
    public function createUser($firstname, $lastname, $email, $login, $password, $avatar){
        $this->logger->logDebug('createUser(' . $firstname . ', ' . $lastname . ', ' . $email . ', ' . $login . ', ' . $password . ', ' . $avatar . ')');
        $retour = FALSE;
        try {
            if (!empty($login)){
                $sql = 'INSERT INTO user (firstname, lastname, email, login, password, avatar) VALUES (:firstname, :lastname, :email, :login, :password, :avatar)';
                $retour = $this->executeSimpleQuery($sql, array(':firstname' => $firstname, 
                                    ':lastname' => $lastname, 
                                    ':email' => $email, 
                                    ':login' => $login, 
                                    ':password' => $password, 
                                    ':avatar' => $avatar));
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