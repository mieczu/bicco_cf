function scrollTo(hash) {
    location.hash = "#" + hash;
}

jQuery(document).ready(function () {

    jQuery('.w-portfolio-item-anchor').click(function (e) {
        e.preventDefault();
        jQuery('.preloader').show();
        jQuery(".w-portfolio-content article").html('');
        scrollTo('produkty-content');

        jQuery.ajax({
            url: "wp-admin/admin-ajax.php",
            method: "POST",
            data: {action: 'get_product', post_id: jQuery(this).parent().attr('data-id')},
            dataType: "json"
        }).done(function (msg) {
            var title = msg.title;
            if (title && title.length > 0){
                var post_title = title;
            }else{
                var post_title = msg.name;
            }

            if (msg.spec.length > 1) {
                // alert(msg.spec.length);
                var download =  '<div syle="float: right;">'+
                    '<a target="_blank" href="' + msg.spec + '">'+
                    '<img src="https://raw.githubusercontent.com/mieczu/abad/master/pdf160.jpg" alt="' + msg.spec + '" style="width: 100px; padding: 15px;"/>'+
                    '</a>'+
                    '</div>';
            } else {
                // alert('nie');
                var download =  '';
            }



            var html = '<div class="w-blog-post-h">'+
                            '<h3 class="w-blog-post-title">' + post_title + '</h3>'+
                            '<div style="float: left; max-width: 350px;">'+
                                '<img width="350" height="350" style="width: auto; max-height: 450px;" src="' + msg.image + '" alt=""/>'+
                            '</div>'+
                            '<div class="w-blog-post-body">'+
                                '<div class="w-blog-post-content">'+ msg.content + '</div>'+
                                download+
                            '</div>'+
                        '</div>';
            jQuery('.preloader').hide();
            jQuery(".w-portfolio-content article").html(html);
            scrollTo('produkty-content');
            // jQuery(document.body).scrollTop(jQuery('#produkty-content').offset().top);
            // alert("Data Saved: " + msg);
        }).fail(function (jqXHR, textStatus) {
            // alert("Request failed: " + textStatus);
            jQuery('.preloader').hide();
            jQuery(".w-portfolio-content article").html('Nie można pobrać zawartości!');
        });
    });

    var active_category = jQuery(".g-filters-item.active").attr('data-category');

    jQuery('.g-filters-item').click(function (e) {

        if (active_category.length > 0) {
        } else {
            active_category = jQuery(this).attr('data-category');
        }

        jQuery('.us_portfolio_category').hide();
        jQuery('#'+active_category).show();

        jQuery(".w-portfolio-content article").html('');

        jQuery('.w-portfolio-item').each(function () {
            if (jQuery(this).hasClass(active_category)) {
                // alert(jQuery(this).attr('data-categories'));
                // jQuery(this).css('display', 'block');
                // jQuery(this).addClass('none');
                jQuery(this).show();
            } else {
                //  jQuery(this).css('visibility', 'hidden');
                // jQuery(this).css('display', 'none');
                // jQuery(this).css('position', 'absolute');
                jQuery(this).hide();
            }
        });
        active_category = '';

    });

    // jQuery('menu-item')

    var active_category = jQuery(".g-filters-item.active").attr('data-category');
// alert(active_category+'2222');
    // jQuery('.w-portfolio-item').not();

    jQuery('.w-portfolio-item').each(function(){
        if (jQuery(this).hasClass(active_category)){
            // alert(jQuery(this).attr('data-categories'));
            // jQuery(this).css('display','');
        }else{
            jQuery(this).hide();
            // jQuery(this).css('visibility', 'hidden');
            // jQuery(this).addClass("display_none");

        }
    });


// alert(jQuery(".g-filters-item.active"))

    // jQuery(".g-filters-item.active").removeClass("active").trigger( "click" ).addClass("dupa");

    // jQuery('.g-filters-item.active').trigger( "click" );

    // jQuery( "[data-category='silosy']" ).addClass("dupa").trigger( "click" );
});
