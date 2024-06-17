 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons Extension -->
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "paging": false,
            "ordering": true,
            "info": false,
            "searching": false, 
            dom: 'Bfrtip',

            
            buttons: [
               
                {
                    extend: 'excelHtml5',
                     text: '<i class="fa-solid fa-file-excel"></i> Export to Excel',
                     className: 'btn btn-success sticky-exportExcel btn-sm'
                }
               
              
               
            ]
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#strandTable').DataTable({
          
        });
    });
</script>

<script>
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#searchTable')) {
    $('#searchTable').DataTable().destroy();
}
       columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                }],
        $('#searchTable').DataTable({
           searching: true,
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#gradesExport').DataTable({
            "paging": false,
            "ordering": true,
            "info": false,
            "searching": false, 
            dom: 'Bfrtip',
           
             "language": {
                "emptyTable": "Import format here"
            },
        

            
            buttons: [
               
                {
               
                    extend: 'excelHtml5',
                     text: '<i class="fa-solid fa-file-excel"></i> Download format here',
                     className: 'btn btn-success sticky-exportExcel btn-sm'
                  
                }
               
              
               
            ]
        });
    });
</script>