/* 
  SolrCollection - simple extension for dealing with solr querying.

  this.params - query params sent to server on fetch()
  this.params.current_page - requested page
  
  on fetch(), expects server to return headers X-Total-Pages and X-Current-Page
*/
WordpressSolrResult = Backbone.Model.extend({
  getDate: function(){
    return Date.parse(this.get('displaydate')).toString('MM/dd/yyyy'); 
  }
});

SolrCollection = Backbone.Collection.extend({

  model: WordpressSolrResult,

  url: 'http://'+window.location.host+':8983/solr/select',
    
  initialize: function(models,o){
    o = o || {};
    this.params = {
      q: o.query || '',
      fq: [],
      start:0,
      rows: 5
    };
    this.offset = 0;
    this.results_returned = 0;
    this.total_results = 0;
    this.total_pages = 1;
    this.current_page = 1;
    this.filters = o.filters || [];
  },

  getQuery: function(){
    return this.params.q;
  },

  setQuery: function(new_query){
    this.params.q = new_query;
    this.fetch();
  },
    
  getParam: function(key){
    return this.params[key];
  },
  
  setParam: function(key,value){
    this.params[key] = value;
  },

  getFilters: function(){
    return _.chain(this.filters)
            .reduce(function(filters,filter_collection){
              return filters.concat(filter_collection.toArray());
            },[])
            .filter(function(filter){
              return filter.isSet();
            }).value()            
  },

  getFilterParams: function(){
    return _.map(this.getFilters(),function(filter){
              return filter.getName()+ '_str:'+filter.getValue();
            });
  },
  
  parse: function(data,xhr){
    this.offset = data.response.start;
    this.results_returned = data.response.docs.length;
    this.total_results = data.response.numFound;
    this.total_pages = Math.ceil(this.total_results / this.getParam('rows'));
    this.current_page = Math.floor(this.offset / this.getParam('rows'))+1;
    if(data.response.docs.length > 0){
      return data.response.docs;
    } else {
      return this.models;
    }
  },

  fetch: function(options){
    options || (options = {});
    if(!options.force && _.isEmpty(this.getQuery())){
      return;
    }
    this.params.fq = this.getFilterParams();
    options.data = this.params;
    options.processData = true;
    options.traditional = true;    
    options.dataType = 'jsonp';
    options.jsonp = 'json.wrf';
    Backbone.Collection.prototype.fetch.call(this, options);
  },
  
  add_to_front: function(model){
    this.models.unshift(model);
    this.trigger('add');
  },
  
  gotoPage: function(page_number){
    this.setParam('start', (page_number-1)*this.getParam('rows'));
    this.fetch();
  },
  
  previousPage: function(){
    if(this.current_page < 2){
      this.gotoPage(1);
    }else{
      this.gotoPage(this.current_page-1);
    }
  },
  
  nextPage: function(){
    if(this.current_page >= this.total_pages){
      this.gotoPage(this.total_pages);
    }else{
      this.gotoPage(this.current_page+1);
    }
  }
  
});
