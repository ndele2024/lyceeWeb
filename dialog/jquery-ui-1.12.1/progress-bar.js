/** 
 * ProgressBar : Simple animated progress bar
 * Author : Nayem > https://facebook.com/sadik5g
 * Version : 1.0.0
 */
(function($){

    $.fn.ProgressBar = function(){
        var targetParent = $(this); 
        targetParent.each(function(){

            //required variables
            var target = $(this).children();
            var offsetTop = $(this).offset().top;
            var winHeight = $(window).height();
            var data_width = target.attr("data-percent") + "%";
            var data_color = target.attr("data-color");

            //animation starts
         /*   if( winHeight > offsetTop ) {
                target.css({
                    backgroundColor: data_color,
                });
                target.animate({
                    width: data_width,
                }, 1000);
            }*/
            //animation with change
            target.css({
                backgroundColor:data_color,
            });
            target.animate({
                width:data_width,
            },1500);
            //animation with scroll 
          /*  $(window).scroll(function(){
                var scrollBar = $(this).scrollTop(); 
                var animateStart = offsetTop - winHeight; 
                if( scrollBar > animateStart ) {
                    target.css({
                        backgroundColor: data_color,
                    });
                    target.animate({
                        width: data_width,
                    }, 1000);
                }
            }); */
        });

        return this; 
    }
})(jQuery)
