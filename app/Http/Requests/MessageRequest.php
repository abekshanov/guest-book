<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'message' => 'required|max:1000',
//            'customFile' => 'image|max:100|dimensions:min_width=100,max_width=500,min_height=100,max_height=500',
            'customFile' => 'image|max:100|dimensions:min_width=100,min_height=100',

        ];
    }

    public function messages()
    {
        return [
            'message.required' => 'Необходимо ввести сообщение',
            'customFile.image' => 'Файл должен быть изображением',
            'message.max' => 'Превышение количества символов',
            'customFile.max'  => 'Размер файла не должен превышать 100кб',
            'customFile.dimensions'  => 'Размер изображения должен быть не менее 100х100 пикселей',

        ];
    }
}
