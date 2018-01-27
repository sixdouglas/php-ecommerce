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
require_once('model/CartModel.php');
require_once('model/ProductModel.php');
require_once('view/View.php');

class CartController extends AbstractController {

  private $logger;
  private $config;
  private $cartModel;
  private $productModel;

  public function __construct($config) {
    $this->config = $config;
    $this->logger = new Logger($config, 'CartController');
    $this->cartModel = new cartModel($config);
    $this->productModel = new ProductModel($config);
  }

  public function cart() {

    $user = null;
    if (isset($_SESSION['user'])){
      $user = $_SESSION['user'];
    }

    $cartProducts = $this->cartModel->getCartProducts($user);

    if(!empty($cartProducts) && !empty($cartProducts[0])){
      $_SESSION['orderId'] = $cartProducts[0]['order_id'];
    }

    $view = new View("Cart");
    $view->render(
      array('productTypes' => [], 
            'cartProducts' => $cartProducts,
            'selectedProductType' => -1,
            'user' => $user
      ), FALSE
    );
  }

  public function addToCart($productId) {
    $user = null;
    if (isset($_SESSION['user'])){
      $user = $_SESSION['user'];
      $product = $this->productModel->getProduct($productId)[0];
      $this->cartModel->addToCart($user, $product);
    }
  }

  public function removeFromCart($orderLineId) {
    $user = null;
    if (isset($_SESSION['user'])){
      $user = $_SESSION['user'];
      $this->cartModel->removeFromCart($user, $orderLineId);
    }
  }

  public function updateCartItem($orderLineId, $quantity){
    $user = null;
    if (isset($_SESSION['user'])){
      $user = $_SESSION['user'];
      $this->cartModel->updateCartItem($user, $orderLineId, $quantity);
    }
  }
}