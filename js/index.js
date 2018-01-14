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

/*Preloader*/
$(window).on('load', function() {
  setTimeout(function() {
    $('body').addClass('loaded');
  }, 200);
});

$(function() {

  "use strict";

  var window_width = $(window).width();
  var openIndex;

  // Notification & Profile Dropdown
  $('.notification-button, .profile-button').dropdown({
    inDuration: 300,
    outDuration: 225,
    constrainWidth: false,
    hover: true,
    gutter: 0,
    belowOrigin: true,
    alignment: 'right',
    stopPropagation: false
  });
});


$(document).ready(function() {
  Materialize.updateTextFields();
  $('select').material_select();

  $('.subremove').click( function() {
    var parents = $(this).parents('form');
    var inputs = parents.children('input.cart-action');
    var value = inputs[0].value;
    console.log("cart-action value: " + value);
    inputs[0].value = 'remove';
  });

  $('.subupdate').click( function() {
    var parents = $(this).parents('form');
    var inputs = parents.children('input.cart-action');
    var value = inputs[0].value;
    console.log("cart-action value: " + value);
    inputs[0].value = 'update';
  });
});
