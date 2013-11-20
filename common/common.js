/**
 * Created with JetBrains PhpStorm.
 * User: sophia
 * Date: 13-11-8
 * Time: 下午2:14
 * To change this template use File | Settings | File Templates.
 */
//客户订单，编辑文本
function editText(id) {
    $('#order_id').val(id);
    $("#faqbg").css({display:"block",height:$(document).height()});
    var txt = $('#txt_' + id).val();

    var yscroll = document.documentElement.scrollTop;
    $("#fckeditor_div").css("width","700px");
    $("#fckeditor_div").css("top","0px");
    $("#fckeditor_div").css("display","block");

    CKEDITOR.instances.content1.setData(txt);
    document.documentElement.scrollTop=0;
}

//客户订单，查看文本
function viewText(id) {
    $('#viewProtocolText').html('');
    $("#faqbg").css({display:"block",height:$(document).height()});
    var txt = $('#txt_' + id).val();
    $('#viewProtocolText').html(txt);

    var yscroll =document.documentElement.scrollTop;
    $("#faqdiv").css("top","0px");
    $("#faqdiv").css("display","block");
    document.documentElement.scrollTop=0;
}

$(function(){
    $(".close").click(function(){
        $("#faqbg").css("display","none");
        $("#faqdiv").css("display","none");
        $("#fckeditor_div").css("display","none");
    });
});