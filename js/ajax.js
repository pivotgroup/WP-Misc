var ajax = ( function(){
	var ajax_url = ge_options.ajax_url; // gotta pass this in somehow
	function ajaxCall( data, cb ){
		cb = cb || function(){};
		return $.ajax({
			url: ajax_url,
			method: 'post',
			data: data,
			dataType: 'html',
			success: cb
		});
	}
	var exampleAction = function( info, cb ){
		return ajaxCall({
			action: 'example_action',
			info: info
		}, cb);
	};
	return {
		exampleAction: exampleAction
	};
}() );