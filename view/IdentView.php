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
  <form class="col s12" method="post" action="index.php">
    <input type="hidden" name="action" value="login" />
    <div class="row">
      <div class="input-field col s12">
        <input name="login" id="login" type="text" class="validate" />
        <label for="login">Login</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <input name="password" id="password" type="password" class="validate" />
        <label for="password">Password</label>
      </div>
    </div>
    <div class="row">
      <div class="col s12">
          <button class="btn waves-effect waves-light" type="submit" name="sublog">Login
              <i class="material-icons right">send</i>
          </button>
          <a class="btn waves-effect waves-light" href="index.php?action=register" name="subreg">Register
              <i class="material-icons right">person_add</i>
          </a>
      </div>
    </div>
  </form>
</div>

<script>
$(document).ready(function() {
    Materialize.updateTextFields();
  });
</script>