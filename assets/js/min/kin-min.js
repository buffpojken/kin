$(document).ready(function(){$("a.likeUpdate").on("click",function(){var e=$(this).text(),t=$(this).data("id"),a=$(this).attr("id");"Like"==e?(request=$.ajax({url:"/",type:"post",data:{ajax:"1",action:"likeUpdate",updateID:t}}),request.done(function(e,t,o){$("a.likeUpdate#"+a).text("Unlike")}),request.fail(function(e,t,a){console.error("The following error occurred: "+t,a)})):(request=$.ajax({url:"/",type:"post",data:{ajax:"1",action:"unlikeUpdate",updateID:t}}),request.done(function(e,t,o){console.log("The following message returned: "+t+" / ",e),$("a.likeUpdate#"+a).text("Like")}),request.fail(function(e,t,a){console.error("The following error occurred: "+t,a)})),event.preventDefault()}),$("form#post-update").submit(function(e){var t=$(this),a=$("textarea#statusUpdate").val(),o=$('input[name="action"]').val(),r=$("ul#updates > li.update:first-child").data("updateId");$("textarea#statusUpdate").prop("disabled",!0),request=$.ajax({url:"/",type:"post",data:{ajax:"1",action:o,statusUpdate:a,latestUpdate:r}}),request.done(function(e,t,a){console.log("The following message returned: "+t+" / ",e),$("textarea#statusUpdate").val(""),$("textarea#statusUpdate").animate({height:30},"normal"),$("ul#updates").hide().prepend(e).fadeIn("slow")}),request.fail(function(e,t,a){console.error("The following error occurred: "+t,a)}),request.always(function(){$("textarea#statusUpdate").prop("disabled",!1)}),e.preventDefault()}),$("textarea#statusUpdate").focus(function(){$(this).animate({height:100},"normal")}),$("textarea#statusUpdate").blur(function(){var e=$(this).val().length;0===e&&$(this).animate({height:30},"normal")})});