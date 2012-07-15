MachineList = Backbone.View.extend({

  initialize: function(o){
    _.bindAll(this,'render');
    this.collection.bind('reset', this.render);
  },
  
  render: function(){
    columns = { //pretty print column titles and their mysql equivs
      'Type of Equipment':'equip_type',
      'VVPAT' : 'vvpat',
      'Vendor' : 'vendor',
      'Make' : 'make',
      'Model' : 'model',
      'Firmware Version' : 'firmware_version',
      'Quantity' : 'quantity'
    };
    var table = '<table class="table table-striped table-bordered">';
    table += '<thead>';
    _(columns).each(function(val,key){
      table += '<th>'+key+'</th>';
    });
    table += '</thead><tbody>';
    _(this.collection.models).each(function(machine){
      table += '<tr>';
      _(columns).each(function(val){
        var contents = machine.attributes[val];
        contents = contents ? contents : 'n/a';
        table+='<Td>'+contents+'</td>';
      });
      table += '</tr>';
    });
    table += '</tbody></table>';
    $(this.el).html(table);
  }
  
  

});
