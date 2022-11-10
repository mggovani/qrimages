@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-header">{{ __('IMAGE UPLOADER') }}</div>

                <form name="imgForm" method="POST" enctype="multipart/form-data" action="{{route('image-upload')}}">
                    @csrf
                    <div class="card-body">
                    <div class="row">
                        <div class="form-check col-sm-12">
                          <input class="form-check-input" type="radio" name="type" id="type1" value="1" {{auth()->user()->last_image_type == 1 ? 'checked' : ''}}>
                          <label class="form-check-label">
                            Portrait
                          </label>
                        </div>
                        <div class="form-check col-sm-12">
                          <input class="form-check-input" type="radio" name="type" id="type2" value="2" {{auth()->user()->last_image_type == 2 ? 'checked' : ''}}>
                          <label class="form-check-label" for="">
                            Landscape
                          </label>
                        </div>
                    </div>  
                    <div class="row mt-2">
                        <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png,.gif" required="" />
                    </div>
                    <div class="row mt-2">
                        <button class="btn btn-success" type="submit">Upload</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
