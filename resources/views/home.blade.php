@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <h5 class="card-header">
                    <a>ToDoList</a>
                    <a style="padding-left: 50px"></a>
                    <a href="{{route('item.create')}}" class="btn btn-sm btn-outline-primary"> Add Item</a>
                </h5>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <form method="POST" action="{{ route('home.filter') }}">
                            @csrf

                            <label for="name" class="col-form-label text-md-right">Show</label>

                            <div class="form-check">
                                <div>
                                    <input class="form-check-input" type="checkbox" name="Easy" id="Easy" @if($easy) checked @endif>
                                    <label class="form-check-label" style="padding-right: 20px" for="Easy"> Easy </label>
                                    <input class="form-check-input" type="checkbox" name="Medium" id="Medium" @if($medium) checked @endif">
                                    <label class="form-check-label" style="padding-right: 20px" for="Medium"> Medium </label>
                                    <input class="form-check-input" type="checkbox" name="Hard" id="Hard" @if($hard) checked @endif>
                                    <label class="form-check-label" style="padding-right: 20px" for="Hard"> Hard </label>
                                </div>
                                <div>
                                    <input class="form-check-input" type="checkbox" name="Mine" id="Mine" @if($mine) checked @endif>
                                    <label class="form-check-label" style="padding-right: 20px" for="Mine"> Mine </label>
                                    <input class="form-check-input" type="checkbox" name="Shared" id="Shared" @if($shared) checked @endif>
                                    <label class="form-check-label" style="padding-right: 20px" for="Shared"> Shared </label>
                                </div>
                                <div>
                                    <input class="form-check-input" type="checkbox" name="Completed" id="Completed" @if($completed) checked @endif>
                                    <label class="form-check-label" style="padding-right: 20px" for="Mine"> Completed </label>
                                    <input class="form-check-input" type="checkbox" name="NotCompleted" id="NotCompleted" @if($not_completed) checked @endif>
                                    <label class="form-check-label" style="padding-right: 50px" for="Mine"> Not Completed </label>
                                    <button type="submit" class="btn btn-sm btn-outline-primary"> Filter</button>
                                </div>
                            </div>

                        </form>

                        <div>
                            <label class="form-check-label" style="padding-right: 50px" for="empty"> </label>
                        </div>

                        <table class="table-hover table-borderless">
                        <tbody>
                        @forelse ($items_to_display as $item)
                            <tr>
                                @if ($item->completed)
                                    <td scope="row"><a href="{{ route('item.edit', $item->id) }}" style="color: black"><s>{{ $item->name }}</s></a></td>
                                @else
                                    <td scope="row"><a href="{{ route('item.edit', $item->id) }}" style="color: black">{{ $item->name }}</a></td>
                                @endif
                                <td>
                                    <a style="padding-left: 50px"></a>
                                    <a href="{{ route('item.edit', $item->id) }}" class="btn btn-sm btn-outline-success"><i class="fa fa-pencil-square-o"></i></a>
                                    <a href="{{ route('item.delete', $item->id) }}" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                No Items Added!
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                        <div>
                            <label class="form-check-label" style="padding-right: 50px" for="empty"> </label>
                        </div>

                        <div>
                            <label for="name" class="col-form-label text-md-right">Page {{$current_page}} of {{$total_pages}} </label>
                            <a @if($current_page != 1) href="{{route('home.previousPage', [$easy, $medium, $hard, $mine, $shared, $completed, $not_completed, $current_page])}}" @endif class="btn btn-sm btn-outline-primary"> << </a>
                            <a @if($current_page != $total_pages) href="{{route('home.nextPage', [$easy, $medium, $hard, $mine, $shared, $completed, $not_completed, $current_page])}}" @endif class="btn btn-sm btn-outline-primary"> >> </a>
                        </div>




            </div>
        </div>
    </div>
</div>

@endsection


