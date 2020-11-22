/* ------------------------------------------------------------------------------
*
*  # Select extension for Datatables
*
*  Specific JS code additions for datatable_extension_select.html page
*
*  Version: 1.0
*  Latest update: Nov 9, 2015
*
* ---------------------------------------------------------------------------- */

$(function() {

    // Basic initialization
    $('.datatable-select-basic').DataTable({
        select: true
    });


    // Single item selection
    $('.datatable-select-single').DataTable({
        select: {
            style: 'single'
        }
    });


    // Multiple items selection
    $('.datatable-select-multiple').DataTable({
        select: {
            style: 'multi'
        }
    });


    // Checkbox selection
    $('.datatable-select-checkbox').DataTable({
        columnDefs: [
            {
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }
        ],
        select: {
            style: 'os',
            selector: 'td:first-child'
        }
    });


    // Buttons
    $('.datatable-select-buttons').DataTable({
        dom: '<"dt-buttons-full"B><"datatable-header"fl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
        buttons: [
            {extend: 'selected', className: 'btn btn-default'},
            {extend: 'selectedSingle', className: 'btn btn-default'},
            {extend: 'selectAll', className: 'btn bg-blue'},
            {extend: 'selectNone', className: 'btn bg-blue'},
            {extend: 'selectRows', className: 'btn bg-teal-400'},
            {extend: 'selectColumns', className: 'btn bg-teal-400'},
            {extend: 'selectCells', className: 'btn bg-teal-400'}
        ],
        select: true
    });
    
});
