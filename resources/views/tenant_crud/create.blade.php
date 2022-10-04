@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a tenant</div>

                    <form method="POST" action="{{ route('main.tenants.store') }}" class="mx-3">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tenant_name_id">Tenant Name*</label>
                                    <input name="name" type="text" class="form-control" id="tenant_name_id"
                                        placeholder="Tenant Name">
                                </div>
                            </div>
                      
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tenant_domain">Tenant Domain*</label>
                                    <input name="domain" type="text" class="form-control" id="tenant_domain"
                                        placeholder="Tenant Domain">
                                </div>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary my-3">Create</button>
                    </form>


                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
