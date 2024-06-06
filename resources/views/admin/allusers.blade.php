<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All users</title>
    <!-- Bootstrap CSS -->
   
   
    <!-- Include other CSS files here -->
    @include('partials.css')
</head>
<body>

@include('partials.navbar')

<div class="wrapper">
    @include('partials.maincontent')
    <div class="card">
        <div class="card-body p-5">
            <h5 class="mb-3 fw-bold text-uppercase">All system users</h5> 

            <div class="table-responsive">
                <table id="table-user" class="table table-bordered"> <!-- Removed 'display' class and added Bootstrap classes -->
                    <thead>
                        <tr>
                            <th>Role</th>
                            <th>Lastname</th>
                            <th>Firstname</th>
                            <th>Middlename</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user['role'] }}</td>
                            <td>{{ $user['lastnames'] }}</td>
                            <td>{{ $user['firstname'] }}</td>
                            <td>{{ $user['middlename'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('partials.script')
<script>
    $(document).ready(function() {
        $('#table-user').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "searching": true, 
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

</body>
</html>
