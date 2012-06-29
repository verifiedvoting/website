Filter = Backbone.Model.extend({
  initialize: function(o){
  },
  isSet:function(){
    return this.get('enabled') || false;
  },
  toggle: function(){
    if(this.get('enabled')) this.set({enabled:false});
    else this.set({enabled:true});
  },
  setOn: function(){
    if(!this.get('enabled')) this.set({enabled:true});
  },
  setOff: function(){
    if(this.get('enabled')) this.set({enabled:false});
  },
  getName: function(){
    return this.get('name');
  },
  setName: function(new_name){
    this.set({value:new_name});
  },
  getValue: function(){
    return this.get('value');
  },
  setValue: function(new_value){
    this.set({value:new_value});
  }
});

FilterCollection = Backbone.Collection.extend({
  model: Filter,
  initialize: function(models,o){
    var col = this;
    this.solr = o.solr;
    this.on('change',function(model){
      col.solr.fetch();
    });
  },
  set:function(o){
    this.name = o.name;
    this.field_name = o.field_name;
    this.value = o.value;
  }
});
