   <div id="form_block">
   <?php $attributes = array('name' => 'forma', 'id' => 'forma');
   echo form_open('login/verifylogin', $attributes); ?>
     <table>
         <tr>
             <td>
                <label for="username">Login:</label>
             </td>
             <td>
                <input type="text" size="20" id="username" name="username"/>
             </td>
         </tr>
         <tr>
             <td>
                <label for="password">Password:</label>
             </td>
             <td>
                <input type="password" size="20" id="password" name="password"/>
             </td>
         </tr>
     </table>
     <br/>
   </form>     
   </div>
   <ul id="main_menu">
    <?php echo '<li><a href="javascript:document.forma.submit();">Login</a>'; ?>
    <?php echo '<li>'.anchor(base_url(), 'Cancel', 'title="Cancel   "'); ?>
   </ul>
<script type="text/javascript">
window.onload = function(){
$('input').keypress(function (e) {
  if (e.which === 13) {
    $('#forma').submit();
    return false;    //<---- Add this line
  }
});    
};
</script>