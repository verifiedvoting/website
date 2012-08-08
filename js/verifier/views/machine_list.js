MachineList = Backbone.View.extend({

  initialize: function(o){
    _.bindAll(this,'render');
    this.collection.bind('reset', this.render);
    this.filters = o.filters;
    this.name = o.name;
  },
  
  render: function(){
    //generate a table based on these column name keys
    columns = { //pretty print column titles and their mysql equivs
      'Make' : 'make',
      'Model' : 'model',
      'Type of Equipment':'equip_type',
      'VVPAT' : 'vvpat',
            'Vendor' : 'vendor',
      'Firmware Version' : 'firmware_version',
    };
    var table = '<b style="font-size:20px;">'+this.name+'</b><Br/>';
    table += '<table class="table table-striped table-bordered">';
    table += '<thead>';
    _(columns).each(function(val,key){
      table += '<th>'+key+'</th>';
    });
    table += '</thead><tbody>';

    //scope hack, can't see same 'this' inside of underscore filter anon funct
    var myFilters = this.filters ? this.filters : [];
    var filtered = _.filter(this.collection.models,function(machine){
      if(myFilters.length>0){//only filter if we're handed filters
        for(i in myFilters){
          if(machine.attributes[myFilters[i]]==1){
            return true;
          }
        }
      } else {
        return true;
      }
      return false;
    });
    
    _(filtered).each(function(machine){
      table += '<tr>';
      _(columns).each(function(val){
        var contents = machine.attributes[val];
        contents = contents ? contents : 'n/a';
        if(val=='vvpat'){
          if(machine.attributes['equip_type'].indexOf('DRE') > -1){
            contents = machine.attributes[val] ? 'Yes' : 'No';
          } else {
            contents = "N/A";
          }
        }
        table+='<Td>'+contents+'</td>';
      });
      table += '</tr>';
    });
    table += '</tbody></table>';
    $(this.el).html(table);
  }
  

});
