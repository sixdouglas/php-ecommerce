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
require_once('model/ShippingModel.php');
require_once('model/UserModel.php');
require_once('model/CartModel.php');
require_once('view/View.php');

class ShippingController extends AbstractController {

  private $logger;
  private $config;
  private $cartModel;
  private $userModel;
  private $shippingModel;

  public function __construct($config) {
    $this->config = $config;
    $this->logger = new Logger($config, 'ShippingController');
    $this->cartModel = new cartModel($config);
    $this->userModel = new UserModel($config);
    $this->shippingModel = new ShippingModel($config);
  }

  public function validateCart() {

    $user = null;
    $orderId = null;
    if (isset($_SESSION['user'])){
      $user = $_SESSION['user'];
    }
    if (isset($_SESSION['orderId'])){
      $orderId = $_SESSION['orderId'];
    }

    $cartProducts = $this->cartModel->getCartProducts($user);

    $address = $this->shippingModel->getCartShippingAddress($orderId);

    if (empty($address)){
      $address = $this->userModel->getDefaultShippingAddress($user);
      $this->shippingModel->saveShippingAddressInOrder($address['addressId'], $orderId);
    }

    $homeDeliveryFees = $this->shippingModel->getHomeDeliveryFees($user, $cartProducts, $address);

    $view = new View("Shipping");
    $view->render(
      array('productTypes'        => [], 
            'cartProducts'        => $cartProducts,
            'address'             => $address,
            'homeDeliveryFees'    => $homeDeliveryFees,
            'selectedProductType' => -1,
            'user'                => $user
      ), FALSE
    );
  }

  public function createAddress(){

    $user = null;
    if (isset($_SESSION['user'])){
      $user = $_SESSION['user'];
    }

    $cartProducts = $this->cartModel->getCartProducts($user);
    $countries = $this->userModel->getCountries();

    $view = new View("NewShippingAddress");
    $view->render(
      array('productTypes'        => [], 
            'cartProducts'        => $cartProducts,
            'selectedProductType' => -1,
            'user'                => $user,
            'countries'           => $countries
      ), FALSE
    );
  }

  public function saveAddress($line1, $line2, $line3, $line4, $line5, $postalCode, $city, $country){

    $user = null;
    $orderId = null;
    if (isset($_SESSION['user'])){
      $user = $_SESSION['user'];
    }
    if(isset($_SESSION['orderId'])){
      $orderId = $_SESSION['orderId'];
    }
    
    $addressId = $this->userModel->saveAddress($user, $line1, $line2, $line3, $line4, $line5, $postalCode, $city, $country);
    $this->shippingModel->saveShippingAddressInOrder($addressId, $orderId);
  }
}