@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Tenants

                        <a type="button" class="btn btn-primary" style="float: right;"
                            href="{{ route('main.tenants.create') }}">Add Tenant</a>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>name</th>
                                <th>domain</th>
                                <th>database</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tenants as $tenant)
                                <tr>
                                    <td>{{ $tenant->id }}</td>
                                    <td>{{ $tenant->name }}</td>
                                    <td>{{ $tenant->domain }}</td>
                                    <td>{{ $tenant->database }}</td>
                                    <td>
                                        <a class="btn btn-danger delete_t" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal" data-tid={{ $tenant->id }}>
                                            <i class='bx bx-trash-alt'></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
    </div>





    <!-- delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    this action cannot be undone
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form id="modal_delete_form" method="POST" action="">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE" />
                        <button type="submit" class="btn btn-danger delete-btn" tenant_id=>delete</button>
                    </form>
                </div>
            </div>
        </div>

    </div>



    <script type="module">
        var deleteModal = document.getElementById('deleteModal');
        var deleteBtn = deleteModal.querySelector('.delete-btn');

        //delete tenant
        deleteBtn.addEventListener('click',function(e){
            
            e.preventDefault();

           var tenant_id = this.getAttribute('tenant_id');
           if(!tenant_id){
            return;
           }

            var form = document.getElementById('modal_delete_form');


           form.action = "{{ route('main.tenants.index') }}/" + tenant_id;  


           form.submit();

           deleteModal.hide();

        });



        deleteModal.addEventListener('show.bs.modal', event => {

            const button = event.relatedTarget;
            // Extract info from data-bs-* attributes
            const recipient = button.getAttribute('data-tid');

            const modalTitle = deleteModal.querySelector('.modal-title');

            modalTitle.textContent = `delete tenant ${recipient} ?`;
            deleteBtn.setAttribute('tenant_id', recipient);
        });



    </script>
@endsection
