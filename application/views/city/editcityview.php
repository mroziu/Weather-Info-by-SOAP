   <div id="form_block">
   <?php $attributes = array('name' => 'forma');

    if (isset($id)) {
        $hidden = array('id' => $id, 'oldcityname' => $name);
    }
    else {
        $hidden = NULL;
    }
    echo form_open('city/verifyeditcity', $attributes, $hidden);
?>
     <table id="form_table">
         <tr>
             <td>
                <label for="cityname">Name:</label>
             </td>
             <td>
                <input type="text" size="30" id="cityname" value="<?php echo $name; ?>" name="cityname"/>
             </td>
         </tr>
     </table>
<br/>
</form>
</div> <!-- form_block -->
   <ul id="main_menu">
    <?php echo '<li><a href="javascript:document.forma.submit();">Update</a>'; ?>
    <?php echo '<li>'.anchor(base_url().'city/city', 'Cancel', array('class' => 'control', 'title' => 'Cancel')); ?>
   </ul>
