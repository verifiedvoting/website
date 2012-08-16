AreaCollection = Backbone.Collection.extend({
  model: Area,
  
  mode : 'country', //either country or state

  fips : 0,
  
  currentName : 'USA',
  
  state : '',
  
  stateFips : 0,
  
  county : '',
  
  countyFips : 0,

  url: '/api',
  
  
  fetch : function(options){
    return Backbone.Collection.prototype.fetch.call(this, options);
  },
  
  parse: function(res,xhr){
  	if(res.error!=0){
  		if(debug.areas) console.log('Error: '+res.message);
  	} else {
      //console.log(res.data);
  	}
    return JSON.parse(res.data);
	},
	
	//external calls
	navigate: function(opt){ 
  	if(opt.mode=='country'){
    	this.mode = opt.mode;
    	map.displayLoading();
    	this.fetch({data:{mode:this.mode}});
  	} else if(opt.mode=="state"){
      this.mode = "state";
      this.stateFips = opt.fips;
      this.fips = opt.fips;
      map.displayLoading();
      this.breadcrumb = 'Verifier - '+this.currentName;
      this.fetch({data:{mode:this.mode,state:this.fips}});
  	} else if(opt.mode=='county'){
      this.mode = "county";
      this.countyFips = opt.fips;
  	}
	}
  
});