(function($) {
    $(document).ready(function($) {
	    $.getScript('/media/custom_admin/filter.js',function(){
		    $('h2:contains("Filter")').after("<h3>By type</h3><ul></ul>");
            var heading = $('h3:contains("By type")');
            var FilterOptions = [{
                                    'title': 'Label',
                                    'qs': [{name: 'speciesimage__isnull', value: 'False'},],
                                },{
                                    'title': 'Record',
                                    'qs': [{name: 'speciesimage__isnull', value: 'True'},],
                                }];
            Filter($, heading, FilterOptions);
	    });
    });
})(django.jQuery);