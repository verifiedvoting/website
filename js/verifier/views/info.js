Info = Backbone.View.extend({

  initialize: function(o){
    _.bindAll(this,'render');
    this.collection.bind('reset', this.render);
  },
  
  render: function(){
    var str = '';
    _(this.collection.models).each(function(official){
      row = official.attributes;
      var infoname = '';
      if(areas.mode=='state'){
        infoname = areas.state;
      } else {
        infoname = areas.county+' County';
      }
      str += "<b>"+infoname+"</b><br/>";
      str += 'Chief Election Official<br/>';
      str += row['title']+'<br/>'+row['first_name'] +" "+ row['last_name']+"<br/>";
      str += row['address_1']+"<br/>";
      if(row['address_2'].length>0){
      str += row['address_2']+"<br/>";
      }
      str += row['city']+" "+row['state']+" "+row['zipcode']+"<br/><br/>";
      str += "Phone "+row['phone']+"<br/>";
      str += "Fax "+row['fax']+"<br/>";
      str += row['email']+"<br/>";
      var web = row['website'].slice(7,30);
      if(row['website'].length > 30){ 
        web += "..."
      }
      str += '<a href="'+row['website']+'">'+"Website"+"</a><br/>";
      
    });
    $(this.el).html(str);
  }
  
});