$(function() {
	"use strict";

    $(document).ready(function() {
        $('#example').DataTable();
        
      } );

      $(document).ready(function() {
        $('#analytic_list').DataTable({
            "pageLength": 30
        });
        
      } );

      $(document).ready(function() {
        var table = $('#example2').DataTable({
        
            orderCellsTop: true,
                    dom: 'Bfrtip',
              buttons: [
                  'copy', 'csv', 'excel', 'pdf', 'print'
              ],
              initComplete: function () {
      
                                  this.api().columns('.head').every( function () {
                                      var column = this;
                                      var select = $('<select><option value=""></option></select>')
                                          .appendTo( $("#example2 thead tr:eq(1) th").eq(column.index()).empty() )
                                          .on( 'change', function () {
                                              var val = $.fn.dataTable.util.escapeRegex(
                                                  $(this).val()
                                              );
      
                                              column
                                                  .search( val ? '^'+val+'$' : '', true, false )
                                                  .draw();
                                          } );
      
                                      column.data().unique().sort().each( function ( d, j ) {
                                          select.append( '<option value="'+d+'">'+d+'</option>' );
                                      } );
                                  } );
                              }
          } );;
    } );

    $(document).ready(function () {
        var table = $('#example4').DataTable({
              rowReorder: true,
                   
              buttons: [
                  'copy', 'csv', 'excel', 'pdf'
              ],
              
          } );
    });


});