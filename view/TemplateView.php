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
<!DOCTYPE html>
<html>
	<head>
        <meta charset="UTF-8">
        <!--Import Google Icon Font-->
        <!--
        <link href="libs/materialicons/v33/icon.css" rel="stylesheet">
        -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!-- Compiled and minified CSS -->
        <!--
        <link rel="stylesheet" href="libs/materialize/0.100.2/css/materialize.min.css">
        -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">

        <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="img/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
        <meta name="theme-color" content="#ffffff">

        <title>PHP E-commerce</title>
        <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
        
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	</head>
	<body class="grey lighten-5">
        <?php echo $header; ?>
        <main class="page">
            <div class="container">
                <?php echo $menu; ?>
                <?php echo $content; ?>
            </div>
        </main>
		
        <?php include('FooterView.php'); ?>

        <!--Import jQuery before materialize.js-->
        <!--
        <script type="text/javascript" src="libs/jquery/3.2.1/jquery-3.2.1.min.js"></script>
        -->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <!-- Compiled and minified JavaScript -->
        <!--
        <script src="libs/materialize/0.100.2/js/materialize.min.js"></script>
        -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
        <script src="js/index.js"></script>
	</body>
</html>