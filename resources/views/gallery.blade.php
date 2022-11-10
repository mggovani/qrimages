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
                @if ($message = Session::get('success'))
				    <div class="alert alert-success">
				        <p>{{ $message }}</p>
				    </div>
				@endif
                <div class="card-header">{{ __('GALLERY') }}</div>
            </div>
            <div class="row">
	            @foreach($all as $img)
	            	@if($img['type'] == 1)
	            		<div class="col-sm-6 text-center">
	            			<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{route('download',$img['name'])}}&choe=UTF-8">
	            		</div>
	            	@else
	            		<div class="col-sm-12 text-center">
	            			<img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{route('download',$img['name'])}}&choe=UTF-8">
	            		</div>
	            	@endif
	            @endforeach
            </div>
        </div>
    </div>
</div>

@endsection