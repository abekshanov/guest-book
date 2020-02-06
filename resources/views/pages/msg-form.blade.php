@extends('layouts.app')

@section('content')
<script>
    $(document).ready(function () {

        $(".answerButtton").bind("click", function () {
            $('.validationErrors').html('').hide();
            $(this).parent().siblings('.answerForm').html($('.messageForm').html());

        });

        $('body').on('click', '.send', function(){
            var thisObject=$(this);
            var fileData = thisObject.closest('form').find('.customFile').prop('files')[0];
            var parentData=thisObject.closest('li').find('.parentId').val();
            var urlDataCurPage=$(location).attr('search');
            var urlData='{{route('guest-book')}}';
            var formData = new FormData();

            // формируем данные для отправки на сервер
            if (fileData) {
                formData.append('customFile', fileData);
            }
            formData.append('message', thisObject.closest('form').find('.message').val());
            if (parentData){
                formData.append('parentId', parentData);
            } else {
                formData.append('parentId', '0');
            }
            formData.append('url', urlData);
            formData.append('urlPage', urlDataCurPage);

            $.ajaxSetup({  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  }});
            $.ajax({
                url: '{{route('send-msg')}}',
                type: 'post',
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                data: formData,
                success: function (data) {
                    console.log(data);

                    $('.validationErrors').html('').hide();
                    $('.message').val('');
                    $('.customFile').val('');

                    // перезагрузка страницы на последнюю или текущую страницу пагинации
                    window.location.href = data['url'];

                },
                error: function(data){
                    console.log(data);
                    global: thisObject;
                    var content='';
                    $.each(data['responseJSON']['errors'], function (key, dataValue) {
                        $.each(dataValue, function (index, value) {
                            content = content + '<li>' + value + '</li>';
                        });

                    });
                    thisObject.closest('form').siblings('.validationErrors').html(content).show();

                 }
             });
         });


    });
</script>

<div class="container">

{{--форма отправки сообщения--}}
    <div  class="messageForm col">
        {{--Вывод ошибок --}}
        <ul class=" alert alert-danger validationErrors"  style="display: none">
        </ul>
        <form method="post" enctype="multipart/form-data">
            <textarea rows="5" name="message" id="" class="message form-control col-4 m-2" type="text" placeholder="Напишите что-нибудь" ></textarea>
            <div class="custom-file col-4 m-2">
                <input type="file" class="customFile custom-file-input" id="" name="customFile" />
                <label class="custom-file-label" for="customFile">Выберите файл</label>
            </div>
            <div class="m-2">
                <input type="button" name="send"  class="send btn btn-primary" value="Отправить" />
            </div>
        </form>
    </div>

{{--вывод сообщений--}}
    <div class="my-3" id="allMsg">
        <h4>Сообщения:</h4>
        <ul class="list-unstyled">
            @each('pages.htmlMessage', $messages, 'message', 'pages.htmlMessage-none')
        </ul>
    </div>
    {{ $messages->links() }}
</div>
@endsection
