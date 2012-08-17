Title = Backbone.View.extend({

  initialize : function(o){
    _.bindAll(this,'render'); //bind our callback functions to the real this
    this.collection.bind('reset',this.render);
  },
  
  render : function(){
    var subtitle = '';
    if(master.mode=='country'){
    
    } else {
      subtitle = ' - <span class="cousub" data-state-fips="'+master.stateFips+'">'+master.stateName+"</span>";
      if(master.mode=='county'){
        subtitle += " - "+master.countyName+" County";
      }
    }
    
    $(this.el).html('<span class="cousub">Verifier</span>'+subtitle);
    
    $('span.cousub').click(function(){
      var stateFips = $(this).attr('data-state-fips');
      if(stateFips){
              master.navigate({mode:'state',fips:stateFips});
      } else {
        master.navigate({mode:'country'});
      }

    });
  }

});