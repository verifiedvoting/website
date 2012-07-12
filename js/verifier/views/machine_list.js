MachineList = Backbone.View.extend({

  initialize: function(o){
    _.bindAll(this,'render');
    this.collection.bind('reset', this.render);
  },
  
  render: function(){
    var table = '<table class="table table-striped table-bordered">';
    table += '<thead><tr><th>Type</th><th>Make</th><th>Model</th></tr></thead>';
    table += '<tbody>';
    _(this.collection.models).each(function(machine){
      table += '<tr>';
      table += _.template(JST['list-view'], {machine:machine.attributes});   
      table += '</tr>';
    });
    table += '</tbody></table>';
    $(this.el).html(table);
  }
  
  

});
