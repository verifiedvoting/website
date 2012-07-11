// it's a good idea to keep everything inside global namespaces so we don't step on our feet
// datastores namespace    
var d = {};
// views namespace    
var v = {};
// javascript templates namespace (JST is jammit's standard location)
var JST = {};


// array of filter collections
d.filters = [];

// solr search api
d.solr = new SolrCollection([],{
  filters: d.filters
});

var router = new Router();

// on pageload
$(function(){

  // compile all available templates using _.template
  $('.jst').each(function(index,el){
    JST[el.id] = _.template($(el).text());
  });
  
  // create all the views
  
  // search results
  v.results = new ListView({
    el: document.getElementById("search-results"),
    collection: d.solr,
    template: 'solr'
  });

  // search pagination
  v.top_paginator = new PaginationView({
    el: document.getElementById("search-top-paginator"),
    collection: d.solr
  });

  v.bottom_paginator = new PaginationView({
    el: document.getElementById("search-bottom-paginator"),
    collection: d.solr
  });
    
  // search query field
  v.search_query = new SearchQueryView({
    el: document.getElementById("search-query"),
    collection: d.solr
  });

  // filter list display
  v.filter_list = new FilterListView({
    el: document.getElementById("filter-list"),
    collection: d.solr
  });  
  
  // Create sidebar search controls
  v.controls = new Backbone.Collection();

  _.each(SELECT_FILTERS,function(filter_group){
      var filters = _.map(filter_group.choices,function(val,key){
        return {name:filter_group.name,value:key,label:val};
      });
      var filter_collection = new FilterCollection(filters,{solr: d.solr});
      filter_collection.set({
        name: filter_group.label,
        field_name: filter_group.name
      });
      d.filters.push(filter_collection);
          
      var select = new Select({
        collection: filter_collection,
        parent_el: document.getElementById('controls')
      });
      v.controls.push(select);
      select.render();
  });
    
  _.each(MULTISELECT_FILTERS,function(filter_group){
    var filter_collection = new FilterCollection(filter_group.filters,{solr: d.solr});
    filter_collection.set({name:filter_group.name, value:'1'});
    d.filters.push(filter_collection);
        
    var select = new MultiSelect({
      collection: filter_collection,
      parent_el: document.getElementById('controls')
    });
    v.controls.push(select);
    select.render();
  });
  
  d.solr.fetch();
  
  Backbone.history.start();
  
  //if we end up here without any #hash we
  if(!location.hash) {
    console.log("dump: "+getQueryParams('q')[0]);
    //v.search_query.setQuery(getQueryParams('q'));
  }
  
  if(!v.search_query.getQuery()) v.search_query.focus();
});


function getQueryParams(qs) {
    qs = qs.split("+").join(" ");
    var params = {},
        tokens,
        re = /[?&]?([^=]+)=([^&]*)/g;

    while (tokens = re.exec(qs)) {
        params[decodeURIComponent(tokens[1])]
            = decodeURIComponent(tokens[2]);
    }

    return params;
}

/**
 * Function : dump()
 * Arguments: The data - array,hash(associative array),object
 *    The level - OPTIONAL
 * Returns  : The textual representation of the array.
 * This function was inspired by the print_r function of PHP.
 * This will accept some data as the argument and return a
 * text that will be a more readable version of the
 * array/hash/object that is given.
 * Docs: http://www.openjs.com/scripts/others/dump_function_php_print_r.php
 */
function dump(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;
	
	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects 
		for(var item in arr) {
			var value = arr[item];
			
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
}