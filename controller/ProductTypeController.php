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
require_once('model/ProductTypeModel.php');
require_once('view/View.php');

class ProductTypeController extends AbstractController {

  private $logger;
  private $config;
  private $productTypeModel;

  public function __construct($config) {
    $this->config = $config;
    $this->logger = new Logger($config, '"ProductTypeController');
    $this->productTypeModel = new ProductTypeModel($config);
  }

  public function getProductType($productTypeId) {
    $products = $this->productTypeModel->getProducts($productTypeId);
    $selectedProductType = $productTypeId;
    $productTypes = $this->productTypeModel->getProductTypes();

    $user = null;
    if (isset($_SESSION['user'])){
      $user = $_SESSION['user'];
    }

    $view = new View("ProductType");
    $view->render(
      array('products' => $products, 
            'productTypes' => $productTypes, 
            'selectedProductType' => $selectedProductType,
            'user' => $user
      ), TRUE
    );
  }
}