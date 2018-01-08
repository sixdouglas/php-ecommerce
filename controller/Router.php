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
require_once 'View/View.php';

class Router {
  private $config;
  private $logger;
  private $mainCtrl;
  
  public function __construct($config) {
    $this->config = $config;
    $this->logger = new Logger("Router");
    $this->mainCtrl = new MainController($config);
  }

  // Deal with incoming requests
  public function routerQuery() {
    $this->logger->logInfo("routerQuery");

    try {
        // display Main page
        $this->mainAction();
    } catch (Exception $e) {
      $this->logger->logError("Exception");
      $this->error($e->getMessage());
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