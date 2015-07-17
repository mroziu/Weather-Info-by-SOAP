<?php
echo '<div id="form_block" class="background_none">
';
echo $datagrid;

echo '<br><br>'.anchor(base_url().'city/city/new_', 'New city', 'title="New city"').anchor(base_url().'weather/admin', 'Back', array('class' => 'control', 'title' => 'Back'));
echo '</div><!--form_block-->';
?>

