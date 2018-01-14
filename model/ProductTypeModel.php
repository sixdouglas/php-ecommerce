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

class ProductTypeModel extends AbstractModel {

    public function __construct($config) {
        parent::__construct($config);
        $this->logger = new Logger($config, 'ProductTypeModel');
    }    

    public function getProductTypes() {
        try {
            $sql = 'SELECT * FROM product_types';
            $productType = $this->executeQuery($sql);
        } catch(PDOException $ex) {
            echo 'An Error occured!';
            echo $ex->getMessage();
        }

        return $productType;
    }

    public function getProducts($productTypeId) {
        try {
            $sql = 'SELECT * FROM products where type=:productTypeId';
            $products = $this->executeQuery($sql, array(':productTypeId' => $productTypeId));
        } catch(PDOException $ex) {
            echo 'An Error occured!';
            echo $ex->getMessage();
        }

        return $products;
    }
}

?>