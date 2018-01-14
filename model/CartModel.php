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

class CartModel extends AbstractModel {

    public function __construct($config) {
        parent::__construct($config);
        $this->logger = new Logger($config, 'CartModel');
    }

    public function getCartProducts($user) {
        try {
            $sql = 'SELECT ord.id as "order_id", lin.id as "line_id", lin.product_id, lin.quantity, lin.price, prd.name, prd.code FROM orders as ord INNER JOIN order_lines as lin ON lin.order_id = ord.id INNER JOIN products as prd ON prd.id = lin.product_id WHERE ord.customer_id = :userId and ord.status = "INCOMPLETE"';
            $cartProducts = $this->executeQuery($sql, array(':userId' => $user['id']));
        } catch(PDOException $ex) {
            echo 'An Error occured!';
            $this->logger->logError($ex->getMessage());
            $this->logger->logError($ex->__toString());
            echo $ex->getMessage();
        }

        return $cartProducts;
    }

    public function addToCart($user, $product) {
        try {
            $sql = 'SELECT ord.id AS "order_id", lin.id AS "line_id" FROM orders AS ord LEFT OUTER JOIN order_lines AS lin ON lin.order_id = ord.id AND lin.product_id = :productId  WHERE ord.customer_id = :userId and ord.status = "INCOMPLETE"';
            $cart = $this->executeQuery($sql, array(':userId' => $user['id'], ':productId' => $product['id']));
            $this->getDb()->beginTransaction();
            if (is_array($cart) && !empty($cart[0])){
                $orderId = $cart[0]["order_id"];
                $lineId = $cart[0]["line_id"];
            } else {
                $sql = 'INSERT INTO orders (customer_id, status) VALUES (:userId, "INCOMPLETE")';
                $cart = $this->executeSimpleQuery($sql, array(':userId' => $user['id']));
                $orderId = $this->getDb()->lastInsertId();
            }
            if (is_null($lineId)){
                $sql = 'INSERT INTO order_lines (order_id, product_id, quantity, cost, price) VALUES (:orderId, :productId, :quantity, :cost, :price)';
                $cart = $this->executeSimpleQuery($sql, array(':orderId' => $orderId, ':productId' => $product['id'], ':quantity' => 1, ':cost' => $product['cost'], ':price' => $product['price']));
            } else {
                $sql = 'UPDATE order_lines SET quantity = quantity + :quantity WHERE id = :lineId';
                $cart = $this->executeSimpleQuery($sql, array(':lineId' => $lineId, ':quantity' => 1));
            }        
            $this->getDb()->commit();
        } catch(PDOException $ex) {
            echo 'An Error occured!';
            $this->logger->logError($ex->getMessage());
            $this->logger->logError($ex->__toString());
            echo $ex->getMessage();
        }
    }

    public function removeFromCart($user, $orderLineId) {
        try {
            $sql = 'SELECT ord.id as "order_id" FROM orders as ord INNER JOIN order_lines as lin ON lin.order_id = ord.id WHERE ord.customer_id = :userId and lin.id = :orderLineId';
            $cart = $this->executeQuery($sql, array(':userId' => $user['id'], ':orderLineId' => $orderLineId));
            if (is_array($cart) && !empty($cart[0])){
                $sql = 'DELETE FROM order_lines WHERE id =:orderLineId';
                $this->getDb()->beginTransaction();
                $cart = $this->executeSimpleQuery($sql, array(':orderLineId' => $orderLineId));
                $this->getDb()->commit();
            }else{
                $this->logger->logError('Order Line Id: ' . $orderLineId . ', does not belong to the current user.');
                throw new Exception('Order Line Id: ' . $orderLineId . ', does not belong to the current user.');
            }
        } catch(PDOException $ex) {
            echo 'An Error occured!';
            $this->logger->logError($ex->getMessage());
            $this->logger->logError($ex->__toString());
            echo $ex->getMessage();
        }
    }

    public function updateCartItem($user, $orderLineId, $quantity) {
        try {
            $sql = 'SELECT ord.id as "order_id" FROM orders as ord INNER JOIN order_lines as lin ON lin.order_id = ord.id WHERE ord.customer_id = :userId and lin.id = :orderLineId';
            $cart = $this->executeQuery($sql, array(':userId' => $user['id'], ':orderLineId' => $orderLineId));
            if (is_array($cart) && !empty($cart[0])){
                $sql = 'UPDATE order_lines SET quantity = :quantity WHERE id = :lineId';
                $this->getDb()->beginTransaction();
                $cart = $this->executeSimpleQuery($sql, array(':lineId' => $orderLineId, ':quantity' => $quantity));
                $this->getDb()->commit();
            }else{
                $this->logger->logError('Order Line Id: ' . $orderLineId . ', does not belong to the current user.');
                throw new Exception('Order Line Id: ' . $orderLineId . ', does not belong to the current user.');
            }
        } catch(PDOException $ex) {
            echo 'An Error occured!';
            $this->logger->logError($ex->getMessage());
            $this->logger->logError($ex->__toString());
            echo $ex->getMessage();
        }
    }
}

?>