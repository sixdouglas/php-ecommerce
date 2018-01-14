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
<div class="row product-detail">
    <div class="col l9 m8 s6">
        <div class="name"><h3><?= $product['name'] ?></h3></div>
        <div class="row">
            <div class="col l4 m4 s4">
                <div class="code"><span class="title">Code: </span><span><?= $product['code'] ?></span></div>
            </div>
            <div class="col l4 m4 s4">
                <div class="vendor"><span class="title">Vendor: </span><span><?= $product['vendor'] ?></span></div>
            </div>
            <div class="col l4 m4 s4">
                <div class="scale"><span class="title">Scale: </span><span><?= $product['scale'] ?></span></div>
            </div>
        </div>
        <div class="description">
            <blockquote><?= $product['description'] ?></blockquote>
        </div>
    </div>
    <div class="col l3 m4 s6">
        <div class="picture"><img src="img/products/<?= $product['code'] ?>.jpg" /></div>
        <div class="price">
            <?= $product['price'] ?> €
            <?php if (!empty($user)){ ?>
            <a href="index.php?action=addToCart&id=<?= $product['id'] ?>" class="btn-floating waves-effect waves-light cyan">
                <i class="material-icons">add_shopping_cart</i>
            </a>
            <?php } ?>
        </div>
    </div>
</div>
