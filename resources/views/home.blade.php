@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Tenants</div>

                    <table class="table">
                        <thead>
                            <tr>
                            <th>id</th>
                            <th>name</th>
                            <th>domain</th>
                            <th>database</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tenants as $tenant)
                            <tr>
                            <td>{{$tenant->id}}</td>
                            <td>{{$tenant->name}}</td>
                            <td>{{$tenant->domain}}</td>
                            <td>{{$tenant->database}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
