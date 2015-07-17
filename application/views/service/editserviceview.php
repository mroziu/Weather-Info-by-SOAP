   <div id="form_block">
   <?php $attributes = array('name' => 'forma');

    if (isset($id)) {
        $hidden = array('id' => $id, 'oldservicename' => $name);
    }
    else {
        $hidden = NULL;
    }
    echo form_open('service/verifyeditservice', $attributes, $hidden);
?>
     <table id="form_table">
         <tr>
             <td>
                <label for="name">Name:</label>
             </td>
             <td>
                <input type="text" size="30" id="name" value="<?php echo $name; ?>" name="name"/>
             </td>
         </tr>
         <tr>
             <td>
                <label for="url">Url:</label>
             </td>
             <td>
                <input type="text" size="60" id="url" value="<?php echo $url; ?>" name="url"/>
             </td>
         </tr>
     </table>
<br/>
</form>
</div> <!-- form_block -->
   <ul id="main_menu">
    <?php echo '<li><a href="javascript:document.forma.submit();">Update</a>'; ?>
    <?php echo '<li>'.anchor(base_url().'service/service', 'Cancel', array('class' => 'control', 'title' => 'Cancel')); ?>
   </ul>
