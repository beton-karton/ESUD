@extends('layouts.app')

@section('content')

<div class="container">
    
        @guest
            <div class="alert alert-secondary" role="alert">
                Залогинься чтобы писать сообщения
            </div>
        @else
            <div class="col-12">
                <a href="/create"><button class="btn btn-primary">Создать сообщение</button></a>
            </div>
        @endguest

    @foreach($msg as $el)
        <div class="col-12" style="border-bottom: 1px solid #ddd; margin-top: 30px; padding-bottom: 15px;">
            <span><b>{{$el->user_name}}</b></span><br><br>
            <img src="{{ Storage::url('image/msg/thumbnail/'.$el->msg_image) }}" alt="">
            <p>{{ $el->msg_body }}</p> 

            <div class="row">
                @foreach($el->child as $ch)
                    <div class="col-1"></div>
                    <div class="col-11">
                        <span><b>{{$ch->user_name}}</b></span><br>
                        <p>{{ $ch->msg_body }}</p>
                    </div>
                @endforeach
            </div>

            @guest
            @else
                <div class="row">  
                    <div class="col-12">
                        <form method="post" action="{{ route('store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="body">Ответное сообщение</label>
                                <textarea class="form-control form-control-sm" id="msg" rows="3" name="msg"></textarea>
                            </div>
                            <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">                        
                            <input type="hidden" id="parent_id" name="parent_id" value="{{$el->msg_id}}">
                            <button type="submit" class="btn btn-primary">Ответить</button>
                        </form>
                    </div>    
                </div>    
            @endguest
            
        </div>
    @endforeach

    <div class="d-flex justify-content-center" style="margin-top: 15px;">
        {!! $msg->links() !!}
    </div>

</div>
@endsection

