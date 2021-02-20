@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                    <form action="{{ route('comments.store') }}" method="post">

                        @csrf

                        <div class="form-group">
                            <textarea name="content" class="form-control"></textarea>
                        </div>

                        <button class="btn btn-primary">Commenter</button>

                    </form>

                    <h2 class="mt-3">Comments</h2>

                    @foreach ($comments as $comment)
                        <p>{{ $comment->content }}</p>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
