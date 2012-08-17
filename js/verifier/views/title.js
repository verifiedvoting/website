Title = Backbone.View.extend({

  initialize : function(o){
    _.bindAll(this,'render'); //bind our callback functions to the real this
    this.collection.bind('reset',this.render);
  },
  
  render : function(){
    var subtitle = '';
    if(master.mode=='country'){
    
    } else {
      subtitle = ' - <span class="map-area" data-state-fips="'+master.stateFips+'">'+master.stateName+"</span>";
      if(master.mode=='county'){
        subtitle += " - "+master.countyName+" County";
      }
    }
    
    $(this.el).html('<span class="map-area">United States</span>'+subtitle);
    
    $('span.map-area').click(function(){
      var stateFips = $(this).attr('data-state-fips');
      if(stateFips){
              master.navigate({mode:'state',fips:stateFips});
      } else {
        master.navigate({mode:'country'});
      }

    });
  }

});