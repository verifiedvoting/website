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
      if(master.mode=='state'){
        infoname = master.stateName;
      } else {
        infoname = master.countyName+' County';
      }
      str += "<h3>"+infoname+"</h3>";
      str += '<b>Chief Election Official</b><br/>';
      str += row['title']+'<br/>'+row['first_name'] +" "+ row['last_name']+"<br/>";
      str += row['address_1']+"<br/>";
      if(row['address_2'].length>0){
        str += row['address_2']+"<br/>";
      }
      str += row['city']+" "+row['state']+" "+row['zipcode']+"<br/>";
      str += "Phone "+row['phone']+"<br/>";
      str += "Fax "+row['fax']+"<br/>";
      str += row['email']+"<br/>";
      var web = row['website'].slice(7,30);
      str += '<a href="'+row['website']+'">'+"Website"+"</a><br/>";
      
      if(row['last_name_additional'].length > 0){
      str += '<br/>';
        str += row['title_additional']+'<br/>'+row['first_name_additional'] +" "+ row['last_name_additional']+"<br/>";
        str += row['address_1_additional']+"<br/>";
        if(row['address_2_additional'].length>0){
        str += row['address_2_additional']+"<br/>";
        }
        str += row['city_additional']+" "+row['state_additional']+" "+row['zipcode_additional']+"<br/>";
        str += "Phone "+row['phone_additional']+"<br/>";
        str += "Fax "+row['fax_additional']+"<br/>";
        str += row['email']+"<br/>";
        var web = row['website_additional'].slice(7,30);
        str += '<a href="'+row['website_additional']+'">'+"Website"+"</a><br/>";        
      }
      
    });
    $(this.el).html(str);
  }
  
});