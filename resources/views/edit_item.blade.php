@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <h5 class="card-header">
                        <a>Edit item '{{ $item->name }}'</a>
                        <a style="padding-left: 50px"></a>
                        <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-arrow-left"></i> Go Back</a>
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

                        <form method="POST" action="{{ route('item.update', $item->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group row">
                                <label for="name" class="col-form-label text-md-right">Name</label>

                                <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $item->name }}" required autocomplete="name" autofocus>

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
                                <input class="form-check-input" type="radio" name="category" id="category1" value="Easy" @if ($item->category == "Easy") checked @endif >
                                <label class="form-check-label" for="category1">
                                    Easy
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="category" id="category2" value="Medium" @if ($item->category == "Medium") checked @endif >
                                <label class="form-check-label" for="category2">
                                    Medium
                                </label>
                            </div>
                            <div class="form-check disabled">
                                <input class="form-check-input" type="radio" name="category" id="category3" value="Hard" @if ($item->category == "Hard") checked @endif >
                                <label class="form-check-label" for="category3">
                                    Hard
                                </label>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-form-label text-md-right">Description</label>

                                <textarea name="description" id="description" cols="30" rows="5" class="form-control @error('password') is-invalid @enderror" autocomplete="description" value="{{ $item->description }}">{{ $item->description }}</textarea>

                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group row">
                                <label for="new_user" class="col-form-label text-md-right">Add user to share with</label>

                                <input id="new_user" name="new_user" type="text" class="form-control @error('shared') is-invalid @enderror" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group row">
                                <label for="shared_with" class="col-form-label text-md-right">This item is being shared between users</label>

                                <textarea readonly name="shared_with" id="shared_with" cols="30" rows="5" class="form-control @error('password') is-invalid @enderror" autocomplete="description" value="{{ $item->shared_with }}">{{ $item->shared_with }}</textarea>

                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group row">
                                <div class="">
                                    <div class="form-check">
                                        @if ($item->completed)
                                            <input class="form-check-input" type="checkbox" name="completed" id="completed" value="{{ $item->completed }}" checked>
                                        @else
                                            <input class="form-check-input" type="checkbox" name="completed" id="completed" value="{{ $item->completed }}">
                                        @endif
                                        <label class="form-check-label" for="completed">
                                            Completed?
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        Submit
                                    </button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

