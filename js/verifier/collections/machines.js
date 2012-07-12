MachineCollection = Backbone.Collection.extend({
  model: Machine,
  
  url: '/api', 

  parse: function(res,xhr){
		if(res.error!=0){
			console.log('Error: '+res.message);
		} else {
			//console.log(res.data);
		}
		return res.data;
  
    /*this.offset = res.response.start;
    this.results_returned = data.response.docs.length;
    this.total_results = data.response.numFound;
    this.total_pages = Math.ceil(this.total_results / this.getParam('rows'));
    this.current_page = Math.floor(this.offset / this.getParam('rows'))+1;
    if(data.response.docs.length > 0){
      return data.response.docs;
    } else {
      return this.models; 
    }*/
  }

});
