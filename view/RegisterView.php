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
    <input type="hidden" name="action" value="create" />
    <div class="input-field col s12 m6">
      <input name="firstname" id="firstname" type="text" class="validate" />
      <label for="firstname">Firstname</label>
    </div>
    <div class="input-field col s12 m6">
      <input name="lastname" id="lastname" type="text" class="validate" />
      <label for="lastname">Lastname</label>
    </div>
    <div class="input-field col s12 m6">
      <input name="email" id="email" type="email" class="validate" />
      <label for="email">Email</label>
    </div>
    <div class="input-field col s12 m6">
      <input name="login" id="login" type="text" class="validate" />
      <label for="login">Login</label>
    </div>
    <div class="input-field col s12 m6">
      <input name="password" id="password" type="password" class="validate" />
      <label for="password">Password</label>
    </div>
    <div id="select" class="input-field col s12 m6">
      <select name="avatar" id="avatar" class="icons">
        <option value="" disabled selected>Choose your option</option>
        <?php
          foreach($avatars as $avatar){
        ?><option value="<?php echo $avatar ?>" data-icon="img/avatar/<?php echo $avatar ?>.png" class="left circle"><?php echo $avatar ?></option>
        <?php
          }
        ?>
      </select>
      <label>Avatar</label>
    </div>  
    <div class="col s12">
        <button class="btn waves-effect waves-light" type="submit" name="subcrea">Create
            <i class="material-icons right">person_add</i>
        </button>
    </div>
  </form>
</div>
