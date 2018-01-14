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

require_once 'controller/MainController.php';
require_once 'controller/SessionController.php';
require_once 'controller/ProductTypeController.php';
require_once 'controller/ProductController.php';
require_once 'controller/CartController.php';
require_once 'View/View.php';

class Router {
  private $config;
  private $logger;
  private $mainCtrl;
  private $sessionCtrl;
  private $productTypeCtrl;
  private $productCtrl;
  private $cartCtrl;

  public function __construct($config) {
    $this->config = $config;
    $this->logger = new Logger($config, 'Router');
    $this->sessionCtrl = new SessionController($config);
    $this->productTypeCtrl = new ProductTypeController($config);
    $this->productCtrl = new ProductController($config);
    $this->mainCtrl = new MainController($config);
    $this->cartCtrl = new CartController($config);
  }

  // Deal with incoming requests
  public function routerQuery() {
    $this->logger->logInfo('routerQuery');

    try {
      if (isset($_GET['action'])) {
        $this->logger->logInfo('GET  action: ' . $_GET['action']);
        if ($_GET['action'] == 'type') {
          $this->typeAction();
        } else if ($_GET['action'] == 'product') {
          $this->productAction();
        } else if ($_GET['action'] == 'ident') {
          $this->identAction();
        } else if ($_GET['action'] == 'logout') {
          $this->logoutAction();
        } else if ($_GET['action'] == 'register') {
          $this->registerAction();
        } else if ($_GET['action'] == 'cart') {
          $this->cartAction();
        } else if ($_GET['action'] == 'addToCart') {
          $this->addToCartAction();
        } else {
          $this->logger->logError('Wrong Action');
          throw new Exception('Wrong Action');
        }
      } else if (isset($_POST['action'])) {
        $this->logger->logInfo('POST action: ' . $_POST['action']);
        if ($_POST['action'] == 'login') {
          $this->loginAction();
        } else if ($_POST['action'] == 'create') {
          $this->createAction();
        } else if ($_POST['action'] == 'remove') {
          $this->removeFromCartAction();
        } else if ($_POST['action'] == 'update') {
          $this->updateCartItemAction();
        } else {  // aucune action définie : affichage de l'accueil
          $this->mainAction();
        }
      } else {  // aucune action définie : affichage de l'accueil
        $this->mainAction();
      }
    } catch (Exception $e) {
      $this->logger->logError('Exception');
      $this->logger->logError($e->__toString());
      $this->error($e->getMessage());
    }
  }

  private function identAction(){
    $this->logger->logInfo('identAction');
    $this->sessionCtrl->ident();
  }

  private function registerAction(){
    $this->logger->logInfo('registerAction');
    $this->sessionCtrl->register();
  }

  private function logoutAction(){
    $this->logger->logInfo('logoutAction');
    $this->sessionCtrl->logout();
    $this->mainAction();
  }

  private function loginAction(){
    $this->logger->logInfo('loginAction');
    $login='';
    $password='';
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
    $this->logger->logInfo('saveUserAction');
    $firstname='';
    $lastname='';
    $email='';
    $login='';
    $password='';
    $avatar='';
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
    $this->logger->logInfo('Main page');
    $this->mainCtrl->main();
  }

  private function typeAction(){
    if (isset($_GET['id'])) {
      $typeId = strval($_GET['id']);
      if (!empty($typeId)) {
        $this->productTypeCtrl->getProductType($typeId);
      } else {
        throw new Exception('Wrong Type Id: ' . $typeId);
      }
    } else {
      throw new Exception('Undefined Line Id');
    }
  }

  private function addToCartAction(){
    $this->logger->logInfo('addToCartAction');
    if (isset($_GET['id'])) {
      $productId = strval($_GET['id']);
      if (!empty($productId)) {
        $this->cartCtrl->addToCart($productId);
      } else {
        throw new Exception('Wrong Product Id: ' . $productId);
      }
    } else {
      throw new Exception('Undefined Product Id');
    }

    $this->cartAction();
  }

  private function removeFromCartAction(){
    $this->logger->logInfo('removeFromCartAction');
    if (isset($_POST['id'])) {
      $orderLineId = strval($_POST['id']);
      if (!empty($orderLineId)) {
        $this->cartCtrl->removeFromCart($orderLineId);
      } else {
        throw new Exception('Wrong Order Line Id: ' . $orderLineId);
      }
    } else {
      throw new Exception('Undefined Order Line Id');
    }

    $this->cartAction();
  }

  private function updateCartItemAction(){
    $this->logger->logInfo('updateCartItemAction');
    if (isset($_POST['id']) && isset($_POST['quantity'])) {
      $orderLineId = strval($_POST['id']);
      $quantity = strval($_POST['quantity']);
      if (!empty($orderLineId) && !empty($quantity)) {
        $this->cartCtrl->updateCartItem($orderLineId, $quantity);
      } else {
        throw new Exception('Wrong Order Line Id: ' . $orderLineId . ', or Quantity not set');
      }
    } else {
      throw new Exception('Undefined Order Line Id or Quantity not set');
    }

    $this->cartAction();
  }

  private function cartAction(){
    $this->logger->logInfo('cartAction');
    $this->cartCtrl->cart();
  }

  private function productAction(){
    if (isset($_GET['id'])) {
      $productId = strval($_GET['id']);
      if (!empty($productId)) {
        $this->productCtrl->getProduct($productId);
      } else {
        throw new Exception('Wrong Product Id: ' . $typeId);
      }
    } else {
      throw new Exception('Undefined Product Id');
    }
  }

  // Erreur display
  private function error($errorMsg) {
    $this->logger->logError('Message: ' . $errorMsg);
    $view = new View('Error');
    $view->render(array('errorMsg' => $errorMsg, 'productTypes' => [], 'selectedProductType' => -1));
  }
}

?>