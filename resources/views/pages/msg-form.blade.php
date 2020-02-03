@extends('layouts.app')

@section('content')
<div class="container">
    <form>
        {{csrf_field()}}
        <input name="message" id="message" class="form-control col-4 m-2" type="text" placeholder="Напишите что-нибудь">
        <div class="custom-file col-4 m-2">
            <input type="file" class="custom-file-input" id="customFile" name="customFile">
            <label class="custom-file-label" for="customFile">Выберите файл</label>
        </div>
        <div class="m-2">
            <button type="button" id="subBut" class="btn btn-primary">Отправить</button>
        </div>
    </form>

</div>
@endsection
