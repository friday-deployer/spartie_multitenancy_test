@extends('tenant.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">upload</div>


                <div class="container mt-5">
                    <form action="{{route('tenant.upload')}}" method="post" enctype="multipart/form-data">
                      <h3 class="text-center mb-5">Upload File </h3>
                        @csrf
                        @if ($message = session()->get('success'))
                        <div class="alert alert-success">
                            <strong>{{ $message }}</strong>
                        </div>
                      @endif
                      @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                  <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                      @endif
                        <div class="form-group">
                            <input type="file" name="image" class="form-controll" id="chooseFile">
                            <label class="form-controll" for="chooseFile">Select file</label>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary btn-block my-4">
                            Upload Files
                        </button>
                    </form>
                </div>

                
                </div>
            </div>



            <div class="col-md-8">
            <div class="card">
                <div class="card-header">files</div>


                <div class="container mt-5">
                    @foreach ($files as $file)
                        <p>{{$file}}</p>
                    @endforeach
                </div>

                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
