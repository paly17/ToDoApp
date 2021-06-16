@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <h5 class="card-header">
                        <a>Add Item</a>
                        <a style="padding-left: 50px"></a>
                        <a href="{{route('home')}}" class="btn btn-sm btn-outline-primary"><i class="fa fa-arrow-left"></i>Go Back</a>
                    </h5>

                    <div class="card-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session()->get('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('item.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-form-label text-md-right">Name</label>

                                <input id="name" type="name" name="name" class="form-control @error('name') is-invalid @enderror"  value="{{ old('email') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group row">
                                <label for="category">Category</label>
                            </div>
                            <div class="form-check">
                                <input id="category" name="category" class="form-check-input" type="radio" value="Easy" >
                                <label class="form-check-label" for="category">
                                    Easy
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" id="category" value="Medium" >
                                <label class="form-check-label" for="category">
                                    Medium
                                </label>
                            </div>
                            <div class="form-check disabled">
                                <input class="form-check-input" type="radio" name="category" id="category" value="Hard" >
                                <label class="form-check-label" for="category">
                                    Hard
                                </label>
                            </div>

                            <div class="form-group row">
                            <label for="description" class="col-form-label text-md-right">Description</label>

                            <textarea name="description" id="description" cols="30" rows="5" class="form-control @error('password') is-invalid @enderror" autocomplete="description" value="{{ old('description') }}"></textarea>

                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>


                            <div class="form-group row">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="completed" id="completed" value="{{ old('completed')}}">

                                    <label class="form-check-label" for="completed">
                                        Completed?
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>

                        </form>



                    </div>
                </div>
            </div>
        </div>

@endsection
