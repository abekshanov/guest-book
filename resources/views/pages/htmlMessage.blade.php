<li class="border-bottom bg-white border-left my-3" >
    <input hidden name="parentId" class="parentId" value="{{$message->id}}">
    <div class=" p-3">
        <h5 class="mt-0">Автор: {{$message->email}}</h5>
        {{$message->text}}
        <img class="d-flex mt-3 " src="{{$message->images}}" alt="">
    </div>
    <div class="media py-1">
        <button type="button" class="answerButtton btn btn-outline-primary m-2 " >Ответить</button>
        <button type="button" class="btn btn-outline-primary m-2" >Редактировать</button>
    </div>
    <div  class=" answerForm"></div>

</li>
@if  ($message['children'])
    @if (count($message['children']) > 0)
        <ul class="list-unstyled ml-5">
            @foreach($message['children'] as $message)
                @include('pages.htmlMessage', $message)
            @endforeach
        </ul>
    @endif
@endif


