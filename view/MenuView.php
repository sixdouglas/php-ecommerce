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

?>
<aside id="left-sidebar-nav">
    <ul id="slide-out" class="side-nav cyan lighten-2 fixed leftside-navigation">
<?php
    foreach($productTypes as $row => $type) {
        $class="bold";
        if ($type['id'] == $selectedProductType){
            $class = $class . " active";
        }
?>
        <li class="<?php echo $class; ?>"><a href="index.php?action=type&id=<?php echo $type['id'] ?>" class="waves-effect white-text"><?php echo $type['type'] ?></a></li>
<?php } ?>
    </ul>
</aside>        