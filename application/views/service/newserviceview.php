   <div id="form_block">
   <?php $attributes = array('name' => 'forma');
   echo form_open('service/verifynewservice', $attributes); ?>
     <table id="form_table">
         <tr>
             <td>
    <label for="name">Name:</label>
             </td>
             <td>
    <input type="text" size="30" id="name" name="name"/>
             </td>
         </tr>
         <tr>
             <td>
    <label for="name">Url:</label>
             </td>
             <td>
    <input type="text" size="60" id="url" name="url"/>
             </td>
         </tr>
     </table>
    <br/>
   </form>
      </div> <!-- form_block -->
   <ul id="main_menu">
    <?php echo '<li><a href="javascript:document.forma.submit();">Save</a>'; ?>
    <?php echo '<li>'.anchor(base_url().'service/service', 'Cancel', array('class' => 'control', 'title' => 'Cancel')); ?>
   </ul>
    