<?php
echo '<div id="form_block" class="background_none">
';
echo $crudTable;
echo '<br><br>'.anchor(base_url().'user/users/new_', 'Nowy użytkownik', 'title="Nowy użytkownik"').anchor(base_url().'telefonista/useraccounts', 'Powrót', array('class' => 'control', 'title' => 'Powrót'));
echo '</div><!--form_block-->';


