/*------------------------------*\

    #FILTERS POSTS

\*------------------------------*/

/**
 * Ajax filter posts
 */

function initFluxiFilterPosts(){

    // SUBMIT

    $('#form-filter-posts').on('submit', function(e){
        var params = $(this).serialize();
        var $data_item = $('.js-controles-more');
        var pt_slug = $data_item.data('slug');
        var paged = $data_item.data('paged');
        var ppp = $data_item.data('ppp');

        var $btn = $('#submit-filters');
        var $btnLabel = $('span');
        var $btnIcon = $btn.find('div');
        $btnIcon.addClass('anim-spin');

        if ( windowW > 1049 ) {
            //show_filters();
        } else {
            $('.js-filters').toggleClass('is-open');
        }

        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: ajax_object.ajax_url,
            data: 'action=fluxi_filter_posts&'+params,
            success: function(data){
                if(data[0].validation == 'error'){
                    $('.js-filters-notify').html('<span class="c-error">'+data[0].message+'</span></div>');
                }else{
                    if(data[0].total > 0){
                        $('.js-filters-notify').html('<span class="c-'+data[0].validation+'">'+data[0].message+'</span>');
                        $('.js-filters-results').html('').append(data[0].content);

                        if( $('.js-load-more').length && data[0].total > ppp ){

                            $data_item.data('paged','1');
                            $data_item.data('total', data[0].total);
                            $data_item.data('cats', data[0].cats.toString());
                            $data_item.data('tags', data[0].tags);
                            $data_item.data('slug', pt_slug);

                        }else if( $('.js-load-more').length && data[0].total <= ppp ){

                            $('.js-load-more').remove();

                        }else if( $('.js-load-more').length == 0 && data[0].total > ppp ){

                            $data_item.html('<button type="button" class="c-button c-button--cta js-load-more"><div class="icon-plus c-button__icon"></div><span>En voir plus</span></button>');
                            $data_item.data('paged','1');
                            $data_item.data('total', data[0].total);
                            $data_item.data('cats', data[0].cats.toString());
                            $data_item.data('tags', data[0].tags);
                            $data_item.data('slug', pt_slug);
                            initLoadMore();

                        }else{ 
                            // Error
                        }

                        if ( $('.js-filter.is-active').length ) {
                            $('.js-reset-filters').removeClass('is-none');
                        } else {
                            $('.js-reset-filters').addClass('is-none');
                        }

                    }else{
                        $('.js-filters-notify').html('<span class="c-error">'+data[0].message+'</span>');
                    }
                }
                $btnIcon.removeClass('anim-spin');
            },
            error : function(jqXHR, textStatus, errorThrown) {
                //console.log(jqXHR + ' :: ' + textStatus + ' :: ' + errorThrown);
                $btnIcon.removeClass('anim-spin');
            }

        });
        return false;
    });

    // OPEN FILTER PANEL

    $('.js-toggle-filters').on('click', function() {
        $('.js-filters').toggleClass('is-open');

        if ( $(this).hasClass('is-visible') ) {
            show_filters();
        }
    });

    // CLIC FILTER 

    $('.js-filter').on('click', function(e) {
        if ( e.target.tagName == 'LABEL' ) {
            $(this).toggleClass('is-active');
            setTimeout(function(){
                $('#form-filter-posts').submit();
            }, 100);
        }
    })

    // RESET 

    $('.js-reset-filters').on('click', function() {
        $('.js-filter').removeClass('is-active');
        setTimeout(function(){
            $('#form-filter-posts').submit();
        }, 100);
    })

    // REMINDER

    $('.js-show-reminder').waypoint(function(direction) {
        if ( direction == 'down' ) {
            $('.js-toggle-filters').addClass('is-visible');
        } else {
            $('.js-toggle-filters').removeClass('is-visible');
        }
    }, {offset: '20%'});
}

function show_filters() {
    var posY = $('.js-filters').offset().top;
    $('body').animate({scrollTop: posY}, 250);
    $('#header').addClass('is-off');
    $('.js-toggle-filters').removeClass('is-visible');
}
