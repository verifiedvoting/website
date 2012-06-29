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
      if(model.isSet()){
        col.solr.setFilter(model.get('name'),model.getValue());
      } else {
        col.solr.unsetFilter({name:model.get('name'),value:model.getValue()});
      }
    });    
  },
  set:function(o){
    this.name = o.name;
    this.field_name = o.field_name;
    this.value = o.value;
  }
});
