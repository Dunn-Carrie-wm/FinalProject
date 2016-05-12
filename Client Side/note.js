/**
 * Created by session2 on 5/5/16.
 */
var toggle = 0;

if (toggle == 0){
    $(document).ready(function(){
        $(".title").click(function(){
            $('#entry').hide();
            $('#result').show();

        });
        toggle = 1;
    });}

else if (toggle == 1){
    $(document).ready(function(){
        $(".title").click(function(){
            $('#result').hide();
            $('#entry').show();
        });
        toggle = 0;
    });}