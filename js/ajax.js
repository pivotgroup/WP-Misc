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

// WP with simple cache
var ajax = ( function(){
	function wpAjaxCall( data, cb ){
		cb = cb || function(){};
		return $.ajax({
			url: wpVars.ajax_url, // wp ajax url
			method: 'post',
			data: data,
			dataType: 'json',
			success: cb
		});
	}
	var _cache = {};
	function cacheHasher( args ){
		var hash = [];
		for (i in args ){
			if ( args.hasOwnProperty(i)){
				if ( typeof( args[i] ) === 'number' || typeof( args[i] ) === 'string' ){
					hash.push( i+':'+args[i] );
				} else if ( typeof( args[i] ) !== 'function' ){
					hash.push( i+':'+JSON.stringify( args[i] ));
				}
			}
		}
		return hash.sort().join(',');
	}
	function cacheResult( args, result ){
		var fnct = args.callee.name;
		if ( ! _cache.hasOwnProperty( fnct ) ){
			_cache[ fnct ] = {};
		}
		var hash = cacheHasher( args );
		_cache[ fnct ][ hash ] = result;
		return hash;
	}
	function getCachedResult( args ){
		var fnct = args.callee.name;
		if ( typeof( _cache[ fnct ] ) !== 'undefined' ){
			var hash = cacheHasher( args );
			if ( typeof( _cache[ fnct ][ hash ] ) !== 'undefined' ){
				return { result: _cache[ fnct ][ hash ] };
			}
		}
		return false;
	}
	function getPostContent(id, cb){
		if ( ! id ){
			cb( false );
			return;
		}
		var cached = getCachedResult( arguments );
		if ( cached ){
			cb( cached.result );
			return;
		}
		var argmnts = arguments;
		return wpAjaxCall({
			action: 'tecore_get_post_content',
			id: id
		}, function( r ){
			cb( r );
		});
	}
	return {
		getPostContent: getPostContent
	};
}() );
