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

$i = 0;

foreach($products as $row => $product) {
    if ($i % 4 == 0){
?>
<div class="row">
<?php        
    }
?>
    <div class="col s12 m12 l3 item product">
        <div class="card">
            <div class="card-image waves-effect waves-block waves-light">
                <a href="#" class="btn-floating btn-large btn-price waves-effect waves-light cyan accent-4"><?= $product['price'] ?> €</a>
                <a href="#" class="default-image">
                    <img src="img/products/<?= $product['code'] ?>.jpg" alt="item-img" onerror="this.src='img/not-found.png';">
                </a>
            </div>
            <ul class="card-action-buttons">
                <li>
                    <a href="index.php?action=product&id=<?= $product['id'] ?>" class="btn-floating waves-effect waves-light cyan">
                        <i class="material-icons">add_shopping_cart</i>
                    </a>
                </li>
                <li>
                    <a class="btn-floating waves-effect waves-light deep-orange accent-2">
                        <i class="material-icons activator">info_outline</i>
                    </a>
                </li>
            </ul>
            <div class="card-content">
                <div class="row">
                    <div class="col s12">
                        <p class="card-title grey-text text-darken-4"><a href="#" class="grey-text text-darken-4"><?= $product['name'] ?></a></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col s6">
                        <span><i>Scale:</i> <?= $product['scale'] ?></span>
                    </div>
                    <div class="col s6">
                        <span><i>Code:</i> <?= $product['code'] ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <span><i>Line:</i> <?= $product['type'] ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <span><i>Vendor:</i> <?= $product['vendor'] ?></span>
                    </div>
                </div>
            </div>
            <div class="card-reveal">
                <span class="card-title grey-text text-darken-4">
                    <i class="material-icons right">close</i> <?= $product['name'] ?>
                </span>
                <p><?= $product['description'] ?></p>
            </div>
        </div>
    </div>
<?php
    $i++;
    if ($i % 4 == 0){
?>
</div>
<?php        
    }
}
?>
