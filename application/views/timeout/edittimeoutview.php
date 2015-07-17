   <div id="form_block">
<?php $attributes = array('name' => 'forma');
    echo form_open('timeout/verifyedittimeout', $attributes);
?>
     <table id="form_table">
         <tr>
             <td>
                <label for="timeout">Timeout:</label>
             </td>
             <td>
                <input type="text" size="2" id="timeout" value="<?php echo $value; ?>" name="timeout"/>
             </td>
         </tr>
     </table>
<br/>
</form>
</div> <!-- form_block -->
   <ul id="main_menu">
    <?php echo '<li><a href="javascript:document.forma.submit();">Update</a>'; ?>
    <?php echo '<li>'.anchor(base_url().'timeout/timeout', 'Cancel', array('class' => 'control', 'title' => 'Cancel')); ?>
   </ul>
