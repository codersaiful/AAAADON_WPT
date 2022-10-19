;(function($){
    $(function(){
        // Pull all the featured products at the first place of the table.
        var _featured_top = $("table.wpt_product_table tr.featured-top");
        if( _featured_top.length ) {
            _featured_top.prependTo("table.wpt_product_table tbody");
        }
    });
}(jQuery));
