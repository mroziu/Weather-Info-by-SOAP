   <div id="form_block">
   <?php $attributes = array('name' => 'forma');
   echo form_open('user/verifynewuser', $attributes); ?>
     <table id="form_table">
         <tr>
             <td>
    <label for="city">City:</label>
             </td>
             <td>
    <?php
        echo $html_options;
    ?>
             </td>
         </tr>
     </table>
     <table id="data_table">
     </table>
    <br/>
   </form>
      </div> <!-- form_block -->

<script>
function load_weather_data() {
    $("#button-get").click(function () {return false;});
    var city = $("#city_name option:selected").val();
    var url = '<?php echo base_url().'weather/get_weather_information/'?>'+city; 
    $("body").css("cursor", "progress");    
    $.ajax({
        type: "GET",
        url: url,
        dataType: 'json',
        success: function(data)
        {
            $('#data_table').html(data);
            $("#data_table").trigger("update");
            $("body").css("cursor", "auto");
        },
        error: function()
        {
            $("body").css("cursor", "auto");
        }
    });
    $("#button-get").unbind('click');
}
</script>
   <ul id="main_menu">
    <?php echo '<li><a id="button-get" href="javascript:load_weather_data();">Get weather information</a>'; ?>
   </ul>
    