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
<header id="header" class="page-topbar">
    <!-- start header nav-->
    <div class="navbar-fixed">
        <nav class="navbar-color cyan">
            <div class="nav-wrapper">
                <ul class="left">
                    <li>
                        <h1 class="logo-wrapper">
                            <a href="index.php" class="brand-logo darken-1">
                                <img src="img/logo.png" alt="Logo">
                                <span class="logo-text hide-on-med-and-down">PHP E-commerce</span>
                            </a>
                        </h1>
                    </li>
                </ul>
                <div class="header-search-wrapper hide-on-med-and-down">
                    <i class="material-icons">search</i>
                    <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore">
                </div>
                <ul class="right hide-on-med-and-down">
                <?php if (!empty($user)){ ?>
                    <li>
                        <a href="index.php?action=cart" class="waves-effect waves-block waves-light notification-button">
                            <i class="material-icons">shopping_cart</i>
                        </a>
                    </li>
                <?php } ?>
                    <li>
                        <a href="javascript:void(0);" class="waves-effect waves-block waves-light notification-button" data-activates="notifications-dropdown">
                            <i class="material-icons">notifications_none
                            </i>
                        </a>
                        <ul id="notifications-dropdown" class="dropdown-content">
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="waves-effect waves-block waves-light profile-button" data-activates="profile-dropdown">
                            <span class="avatar-status avatar-online">
                            <?php if (empty($user)){ ?>
                                <img src="img/avatar/unlogged.png" alt="avatar">
                            <?php } else { ?>
                                <img src="img/avatar/<?php echo $user["avatar"] ?>.png" alt="avatar">
                            <?php } ?>
                                <i></i>
                            </span>
                        </a>
                        <ul id="profile-dropdown" class="dropdown-content">
                            <li>
                                <a href="#" class="grey-text text-darken-1">
                                <i class="material-icons">live_help</i> Help</a>
                            </li>
                            <li class="divider"></li>
                            <?php if (empty($user)){ ?>
                            <li>
                                <a href="index.php?action=ident" class="grey-text text-darken-1">
                                <i class="material-icons">open_in_browser</i> Login</a>
                            </li>
                            <?php } else { ?>
                            <li>
                                <a href="index.php?action=logout" class="grey-text text-darken-1">
                                <i class="material-icons">exit_to_app</i> Logout</a>
                            </li>
                            <?php } ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
