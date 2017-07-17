/*======================================================================*\
==========================================================================

                                 JS READY

==========================================================================
\*======================================================================*/

var FOO = {
    common: {
        init: function() {            
            jQuery('.fitvid').fitVids();            
        }
    },
    page_has_filters: {
        init: function(){
            initFluxiFilterPosts();
            initLoadMore();            
        }
    },
    home: {
        init: function() {
            isHome = true;
            initMap();
        }
    },
    js_contact_form: {
        init: function() {
            initFormContact();
        }
    },
    page_template_page_thematique: {
        init: function() {
            init_tabs();
            active_current_cat();
            img_titre();
        }
    }
    
};

var UTIL = {
    fire: function(func, funcname, args) {
        var namespace = FOO;
        funcname = (funcname === undefined) ? 'init' : funcname;
        if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
          namespace[func][funcname](args);
        }
    },
    loadEvents: function() {
        UTIL.fire('common');
        jQuery.each(document.body.className.replace(/-/g, '_').split(/\s+/),function(i,classnm) {
          UTIL.fire(classnm);
        });
    }
};

jQuery(document).ready(UTIL.loadEvents);




