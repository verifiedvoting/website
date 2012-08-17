function Master(){
  this.mode='country';
  
  this.stateFips= 0;
  
  this.stateName= '';
  
  this.countyFips= 0;
  
  this.countyName='';
  
  this.sayHelloMaster = function(){
    console.log('hello master');
  }
  
	//external calls
	this.navigate = function(opt){ 
  	if(opt.mode=='country'){
    	this.mode = opt.mode;
    	v.map.displayLoading();
    	c.areas.fetch({data:{mode:this.mode}});
  	} else if(opt.mode=="state"){
      this.mode = "state";
      this.stateFips = opt.fips;
      v.map.displayLoading();
      c.areas.fetch({
        data:{
          mode:this.mode,
          state:this.stateFips
        }
      });
      c.officials.fetch({
        data:{
          state:this.stateFips
        }
      });
      c.machines.fetch({
        data:{
          state:this.stateFips
        }
      });
      
  	} else if(opt.mode=='county'){
      this.mode = "county";
      this.countyFips = opt.fips;
      
      c.machines.fetch({
        data:{
          state:this.stateFips,
          county:this.countyFips
        }
      });
      c.officials.fetch({
        data:{
          state:this.stateFips,
          county:this.countyFips
        }
      });
  	}
  	v.title.render();
	}
	
	return this;
}
