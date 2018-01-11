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

require_once 'controller/MainController.php';
require_once 'controller/SessionController.php';
require_once 'View/View.php';

class Router {
  private $config;
  private $logger;
  private $mainCtrl;
  private $sessionCtrl;
  
  public function __construct($config) {
    $this->config = $config;
    $this->logger = new Logger("Router");
    $this->sessionCtrl = new SessionController($config);
    $this->mainCtrl = new MainController($config);
  }

  // Deal with incoming requests
  public function routerQuery() {
    $this->logger->logInfo("routerQuery");

    try {
      if (isset($_GET['action'])) {
        $this->logger->logInfo('GET  action: ' . $_GET['action']);
        if ($_GET['action'] == 'ident') {
          $this->identAction();
        } else if ($_GET['action'] == 'logout') {
          $this->logoutAction();
        } else if ($_GET['action'] == 'register') {
          $this->registerAction();
        } else {
          $this->logger->logError("Wrong Action");
          throw new Exception("Wrong Action");
        }
      } else if (isset($_POST['action'])) {
        $this->logger->logInfo('POST action: ' . $_POST['action']);
        if ($_POST['action'] == 'login') {
          $this->loginAction();
        } else if ($_POST['action'] == 'create') {
          $this->createAction();
        } else {  // aucune action définie : affichage de l'accueil
          $this->mainAction();
        }
      } else {  // aucune action définie : affichage de l'accueil
        $this->mainAction();
      }
    } catch (Exception $e) {
      $this->logger->logError("Exception");
      $this->error($e->getMessage());
    }
  }

  private function identAction(){
    $this->logger->logInfo("identAction");
    $this->sessionCtrl->ident();
  }

  private function registerAction(){
    $this->logger->logInfo("registerAction");
    $this->sessionCtrl->register();
  }

  private function logoutAction(){
    $this->logger->logInfo("logoutAction");
    $this->sessionCtrl->logout();
    $this->mainAction();
  }

  private function loginAction(){
    $this->logger->logInfo("loginAction");
    $login="";
    $password="";
    if (isset($_POST['login'])) {
      $login = strval($_POST['login']);
    }
    if (isset($_POST['password'])) {
      $password = strval($_POST['password']);
    }
    if (!empty($login) && !empty($password)) {
      $loginReturn = $this->sessionCtrl->login($login, $password);
      if ($loginReturn){
        $this->mainAction();
      } else {
        $this->sessionCtrl->ident();
      }
    }else{
      $this->sessionCtrl->ident();
    }
  }

  private function createAction(){
    $this->logger->logInfo("saveUserAction");
    $firstname="";
    $lastname="";
    $email="";
    $login="";
    $password="";
    $avatar="";
    if (isset($_POST['firstname'])) {
      $firstname = strval($_POST['firstname']);
    }
    if (isset($_POST['lastname'])) {
      $lastname = strval($_POST['lastname']);
    }
    if (isset($_POST['email'])) {
      $email = strval($_POST['email']);
    }
    if (isset($_POST['login'])) {
      $login = strval($_POST['login']);
    }
    if (isset($_POST['password'])) {
      $password = strval($_POST['password']);
    }
    if (isset($_POST['avatar'])) {
      $avatar = strval($_POST['avatar']);
    }
    if (!empty($login) && !empty($password) && !empty($email)) {
      $createReturn = $this->sessionCtrl->createUser($firstname, $lastname, $email, $login, $password, $avatar);
      if ($createReturn){
        $this->mainAction();
      } else {
        $this->sessionCtrl->register();
      }
    }else{
      $this->sessionCtrl->register();
    }
  }

  private function mainAction(){
    $this->logger->logInfo("Main page");
    $this->mainCtrl->main();
  }

  // Erreur display
  private function error($errorMsg) {
    $this->logger->logError("Message: " . $errorMsg);
    $view = new View("Error");
    $view->render(array('errorMsg' => $errorMsg));
  }
}

?>