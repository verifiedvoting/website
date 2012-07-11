Machine = Backbone.Model.extend({

});

MachineCollection = Backbone.Collection.extend({
  model:Machine,
  
  url: 'http://'+window.location.host+'/wp-content/themes/verified_voting/verifier/api.php', 

  parse: function(data,xhr){
  if(data.error!=0){
    console.log('Error: '+data.message);
  } else {
    console.log(data.data);
  }
  
    /*this.offset = data.response.start;
    this.results_returned = data.response.docs.length;
    this.total_results = data.response.numFound;
    this.total_pages = Math.ceil(this.total_results / this.getParam('rows'));
    this.current_page = Math.floor(this.offset / this.getParam('rows'))+1;
    if(data.response.docs.length > 0){
      return data.response.docs;
    } else {
      return this.models; 
    }*/
  },
  

});


