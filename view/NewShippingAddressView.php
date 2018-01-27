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
    <form class="col s9 row shipping-address-form" method="post" action="index.php">
        <div class="collection">
            <div class="row collection-item">
                <div class="col s2">
                    <p>
                    </p>
                </div>
                <div class="col s8">
                    <input type="hidden" name="action" value="saveAddress" />
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="line1" id="line1" type="text" class="validate" />
                            <label for="line1">Line 1</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="line2" id="line2" type="text" class="validate" />
                            <label for="line2">Line 2</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="line3" id="line3" type="text" class="validate" />
                            <label for="line3">Line 3</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="line4" id="line4" type="text" class="validate" />
                            <label for="line4">Line 4</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="line5" id="line5" type="text" class="validate" />
                            <label for="line5">Line 5</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s4">
                            <input name="postalCode" id="postalCode" type="text" class="validate" />
                            <label for="postalCode">Postal Code</label>
                        </div>
                        <div class="input-field col s8">
                            <input name="city" id="city" type="text" class="validate" />
                            <label for="city">City</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <select name="country" id="country" class="validate" >
                                <option value="" disabled selected>Choose your option</option>
                                <?php
                                foreach($countries as $row => $country) { ?>
                                <option value="<?= $country['countryCode'] ?>" ><?= $country['countryName'] ?></option>
                                <?php } ?>
                            </select>
                            <label for="country">Country</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6">
                            <a class="btn waves-effect waves-light cyan" href="index.php?action=validate" name="subreg">Cancel
                                <i class="material-icons right">chevron_left</i>
                            </a>
                        </div>
                        <div class="col s6 right-align">
                            <button class="btn waves-effect waves-light cyan" type="submit" name="sublog">Save
                                <i class="material-icons right">save</i>
                            </button>
                        </div>
                    </div>  
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