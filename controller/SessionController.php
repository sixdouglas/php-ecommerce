<?php
/*
 * Copyright 2018 the original author or authors.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once('AbstractController.php');
require_once('model/UserModel.php');
require_once('model/ProductTypeModel.php');
require_once('utils/FileTools.php');

class SessionController extends AbstractController {
  private $logger;
  private $config;
  private $fileTools;
  private $userModel;
  private $productTypeModel;
  
  public function __construct($config) {
    $this->config = $config;
    $this->logger = new Logger($config, 'SessionController');
    $this->fileTools = new FileTools($config);
    $this->userModel = new UserModel($config);
    $this->productTypeModel = new ProductTypeModel($config);
  }

  public function ident($showError = false) {
    $this->logger->logInfo('ident: ' . $showError);
    $productTypes = $this->productTypeModel->getProductTypes();
    $view = new View("Ident");
    $view->render(
      array('productTypes' => $productTypes,
            'selectedProductType' => -1
      ), FALSE
    );
  }

  public function register($showError = false) {
    $this->logger->logInfo('register: ' . $showError);
    $productTypes = $this->productTypeModel->getProductTypes();
    $avatars = $this->fileTools->findAvatars();
    $view = new View("Register");
    $view->render(
      array('productTypes' => $productTypes, 
            'selectedProductType' => -1,
            'avatars' => $avatars
      ), FALSE
    );
  }

  public function createUser($firstname, $lastname, $email, $login, $password, $avatar){
    $this->logger->logInfo('createUser: ' . $firstname . ', ' . $lastname . ', ' . $email . ', ' . $login . ', ' . $password . ', ' . $avatar);
    $isCreated = $this->userModel->createUser($firstname, $lastname, $email, $login, $password, $avatar);
    if ($isCreated){
      $user = $this->userModel->getUser($login);
      $this->logger->logInfo($user);
      $_SESSION['user'] = $user[0];
    }
    return $isCreated;
  }

  public function login($login, $password) {
    $this->logger->logInfo('login: ' . $login . ', ' .$password);
    $isLogged = $this->userModel->login($login, $password);
    $this->logger->logInfo('isLogged: ' . $isLogged);
    if ($isLogged){
      $user = $this->userModel->getUser($login);
      $this->logger->logInfo($user);
      $_SESSION['user'] = $user[0];
    }
    return $isLogged;
  }

  public function logout() {
    $this->logger->logInfo('logout');
    session_unset();
    session_destroy();
  }
}

?>