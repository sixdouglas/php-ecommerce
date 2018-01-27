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
    <form class="col s9 row shipping-form" method="post" action="index.php">
        <div class="collection">
            <div class="row collection-item">
                <div class="col s2">
                    <p>
                        <input class="with-gap" name="shippingGroup" type="radio" id="homeDelivery" checked />
                        <label for="homeDelivery">Home Delivery</label>
                    </p>
                </div>
                <div class="col s8">
                    <p class="grey-text text-darken-4 center-align">
                    <?php if (!empty($address)) { ?>
                        <?php if (!empty($address['line1'])) { echo($address['line1'] . "<br />"); } ?>
                        <?php if (!empty($address['line2'])) { echo($address['line2'] . "<br />"); } ?>
                        <?php if (!empty($address['line3'])) { echo($address['line3'] . "<br />"); } ?>
                        <?php if (!empty($address['line4'])) { echo($address['line4'] . "<br />"); } ?>
                        <?php if (!empty($address['line5'])) { echo($address['line5'] . "<br />"); } ?>
                        <?= $address['postalCode'] ?> <?= $address['cityName'] ?>
                        <?= $address['countryName'] ?>
                    <?php } else { ?>
                        <a class="btn waves-effect waves-light cyan" href="index.php?action=createAddress" name="subCreateAddress">Add Address
                            <i class="material-icons">home</i>
                        </a>
                    <?php } ?>
                    </p>
                </div>
                <div class="col s2">
                    <p class="grey-text text-darken-4 right-align"><?= $homeDeliveryFees ?> €</p>
                </div>
            </div>
        </div>
    </form>
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
                <?php if (!empty($address)) { ?>
                    <a class="btn waves-effect waves-light cyan" href="index.php?action=validate" name="subValidate">Validate
                        <i class="material-icons">chevron_right</i>
                    </a>
                <?php } ?>
                </p>
            </div>
        </div>
    </div>
</div>