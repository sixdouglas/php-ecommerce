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

class View {

  // PHP File name linked to the view
  private $file;

  public function __construct($action) {
    // Create the PHP file name from the current action
    $this->file = 'view/' . $action . 'View.php';
  }

  // Render and display the View
  public function render($data, $withMenu) {
    // Start output buffering
    ob_start();
    // Render the Header
    $header = $this->renderFile('view/HeaderView.php', $data);
    ob_clean();

    // Render the Menu
    if ($withMenu){
      $menu = $this->renderFile('view/MenuView.php', $data);
      ob_clean();
    }else{
      $menu = null;
    }
    
    // Render the Content
    $content = $this->renderFile($this->file, $data);
    ob_clean();

    // Render the Template filling blanks with Header and Content
    $view = $this->renderFile('view/TemplateView.php', array('header' => $header, 'menu' => $menu, 'content' => $content));
    // Send View to browser
    ob_end_flush();
  }

  // Render the file with input data
  private function renderFile($file, $data) {
    if (file_exists($file)) {
      // Split data array into multiple variables
      extract($data);
      // Include file view
      // result is added to output buffer
      require $file;
      // stop buffering and send output to browser
      return ob_get_contents();
    }
    else {
      throw new Exception('file \'' . $file . '\' not found');
    }
  }
}

?>