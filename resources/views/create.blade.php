@extends('layouts.app')

@section('content')

<div class="container">
    <div class="col-8">
        <h1>Добавить сообщение</h1>
        <form method="post" action="{{ route('store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="body">Сообщение</label>
                <textarea class="form-control" id="msg" rows="3" name="msg"></textarea>
            </div>
            <div class="form-group">
                <label for="image">Картинка</label>
                <input type="file" class="form-control-file" id="image" name="image">
            </div>
            <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
            <input type="hidden" id="parent_id" name="parent_id" value="0">
            <button type="submit" class="btn btn-primary">Добавить</button>
        </form>
    </div>
</div>
@endsection

