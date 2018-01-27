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
<div class="row">
    <div class="col s9">
        <div id="cart" class="collection cart">
        <?php
        foreach($cartProducts as $row => $product) {
        ?>
            <div class="row collection-item">
                <form class="col s12 product-form" method="post" action="index.php">
                    <input type="hidden" class="cart-action" name="action" value="remove" />
                    <input type="hidden" class="line-id" name="id" value="<?= $product['line_id'] ?>" />
                    <div class="row">
                        <div class="col s2">
                            <a href="index.php?action=product&id=<?= $product['product_id'] ?>" class="default-image">
                                <img class="z-depth-1" src="img/products/<?= $product['code'] ?>.jpg" alt="item-img" onerror="this.src='img/not-found.png';">
                            </a>
                        </div>
                        <div class="col s4">
                            <p class="grey-text text-darken-4">
                                <?= $product['name'] ?>
                            </p>
                        </div>
                        <div class="col s2">
                            <input type="number" name="quantity" class="grey-text text-darken-4 right-align" value="<?= $product['quantity'] ?>" />
                        </div>
                        <div class="col s1">
                            <p>
                                <button class="btn-floating btn-small waves-effect wave-light cyan subupdate" data-id="<?= $product['line_id'] ?>" type="submit" name="subupdate">
                                    <i class="material-icons right">settings_backup_restore</i>
                                </button>
                            </p>
                        </div>
                        <div class="col s2">
                            <p class="grey-text text-darken-4 right-align"><?= $product['price'] ?> €</p>
                        </div>
                        <div class="col s1">
                            <p class="right-align">
                                <button class="btn-floating btn-small waves-effect waves-light red accent-2 subremove" type="submit" name="subremove">
                                    <i class="material-icons right">clear</i>
                                </button>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        <?php        
        }
        ?>
        </div>
    </div>
    <div class="col s3">
        <div class="card cart-summary">
            <div class="row">
                <div class="col s12">
                    <p class="title cyan white-text">CART SUMMARY</p>
                </div>
            </div>
            <?php 
            $total = 0;
            foreach($cartProducts as $row => $product) { 
                $linePrice = $product['price'] * $product['quantity'];
                $total = $total + $linePrice;
            ?>
            <div class="row line">
                <div class="col s6">
                    <p class="grey-text text-darken-4"><?= $product['name'] ?></p>
                </div>
                <div class="col s6">
                    <p class="grey-text text-darken-4 right-align"><?= $linePrice ?> €</p>
                </div>
            </div>
            <?php } ?>
            <div class="row">
                <div class="col s6 total">
                    <p class="grey-text text-darken-4 total-label grey lighten-4">Total</p>
                </div>
                <div class="col s6 total">
                    <p class="grey-text text-darken-4 right-align total-price grey lighten-4"><?php echo($total) ?> €</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <p class="right-align">
                    <a class="btn waves-effect waves-light cyan" href="index.php?action=validate" name="subValidate">Validate
                        <i class="material-icons">chevron_right</i>
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>