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
            if (title && title.length > 0) {
                var post_title = title;
            } else {
                var post_title = msg.name;
            }

            if (msg.spec.length > 1) {
                var download = '<div syle="float: right;">' +
                    '<a target="_blank" href="' + msg.spec + '">' +
                    '<img src="https://raw.githubusercontent.com/mieczu/abad/master/pdf160.jpg" alt="' + msg.spec + '" style="width: 100px; padding: 15px;"/>' +
                    '</a>' +
                    '</div>';
            } else {
                var download = '';
            }

            var html = '<div class="w-blog-post-h">' +
                '<h3 class="w-blog-post-title">' + post_title + '</h3>' +
                '<div style="float: left; max-width: 350px;">' +
                '<img width="350" height="350" style="width: auto; max-height: 450px;" src="' + msg.image + '" alt=""/>' +
                '</div>' +
                '<div class="w-blog-post-body">' +
                '<div class="w-blog-post-content">' + msg.content + '</div>' +
                download +
                '</div>' +
                '</div>';
            jQuery('.preloader').hide();
            jQuery(".w-portfolio-content article").html(html);
            scrollTo('produkty-content');
        }).fail(function (jqXHR, textStatus) {
            jQuery('.preloader').hide();
            jQuery(".w-portfolio-content article").html('Nie można pobrać zawartości!');
        });
    });

    var active_item = jQuery(".g-filters-item.active");

    var active_category = active_item.attr('data-category');

    var first = false;

    jQuery('.g-filters-item').click(function (e) {
        if (first) {
            jQuery(".g-filters-item.active").removeClass('active');

            jQuery(this).addClass('active');
        } else {
            first = true;
        }

        if (active_category.length > 0) {
        } else {
            active_category = jQuery(this).attr('data-category');
        }

        jQuery('.us_portfolio_category').hide();
        jQuery('#' + active_category).show();

        jQuery(".w-portfolio-content article").html('');

        jQuery('.w-portfolio-item').each(function () {
            if (jQuery(this).hasClass(active_category)) {
                jQuery(this).show();
            } else {
                jQuery(this).hide();
            }
        });
        active_category = '';
    });

    var active_category = jQuery(".g-filters-item.active").attr('data-category');

    jQuery('.w-portfolio-item').each(function () {
        if (jQuery(this).hasClass(active_category)) {
        } else {
            jQuery(this).hide();
        }
    });

    jQuery('.menu-item .menu-item').click(function(){

        switch(jQuery(this).attr('id')) {
            case 'menu-item-1171':
                jQuery( "[data-category='urzadzenia-typu-r']").click();
                break;
            case 'menu-item-1178':
                jQuery( "[data-category='model-r']").click();
                break;
            case 'menu-item-1186':
                jQuery( "[data-category='urzadzenia-typu-r']").click();
                break;
            case 'menu-item-1172':
                jQuery( "[data-category='urzadzenia-typu-rv']").click();
                break;
            case 'menu-item-1179':
                jQuery( "[data-category='model-rv']").click();
            case 'menu-item-1187':
                jQuery( "[data-category='urzadzenia-typu-rv']").click();
                break;
            case 'menu-item-1173':
                jQuery( "[data-category='mlynki-do-kawy']").click();
                break;
            case 'menu-item-1180':
                jQuery( "[data-category='coffee-grinder']").click();
                break;
            case 'menu-item-1188':
                jQuery( "[data-category='mlynki-do-kawy']").click();
                break;
            case 'menu-item-1174':
                jQuery( "[data-category='silosy']").click();
                break;
            case 'menu-item-1181':
                jQuery( "[data-category='de-stoner']").click();
                break;
            case 'menu-item-1189':
                jQuery( "[data-category='silosy']").click();
                break;
        }

    });

});
