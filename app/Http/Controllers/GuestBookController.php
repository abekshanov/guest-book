<?php

namespace App\Http\Controllers;

use App\Classes\Services\MessageService;
use App\Http\Requests\MessageRequest;
use Exception;
use App\Classes\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestBookController extends Controller
{
    // Вывод формы
    public function index(Request $request)
    {
        $messages=MessageService::getPaginated($request->url());
        return view('pages.msg-form', compact('messages'));
    }

    // обработчик формы
    public function formHandler(MessageRequest $request)
    {
        try {
            $formData = $request->all();

            if ($request->hasFile('customFile')) {
                //проверяем: если файл получен

                //сохраняем файл по указанному пути, запоминаем путь
                $path = $request->file('customFile')->store('images', 'public');
                $pathImg = 'storage/'.$path;
                $path = asset($pathImg); //получаем src в виде url к img

                // изменяем размер файла пропорцинально исходным соотношениям сторон
                Helpers::resizeImg($pathImg, 500, 500);

                //  добавляем новую запись (сообщение) в БД
                if ($formData['message']) {
                    MessageService::create($formData['message'], $formData['parentId'], $path);
                }

            }
            else {
                //если файл не получен
                //  добавляем новую запись (сообщение) в БД
                if ($formData['message']) {
                    MessageService::create($formData['message'], $formData['parentId']);
                }

            }

            //------- получаем url последней страницы пагинации или оставляем текущую
            if ($formData['parentId']==0) {
                // если форма добавляет новое сообщение (в корень), то формируем url последней страницы пагинации
                $messages=MessageService::getPaginated($formData['url']);
                $urlLastPage=$messages->url($messages->lastPage());
                $url=$urlLastPage;
            }else {
                // если форма добавляет ответ на сообщение (дочернее сообщение), то формируем url текущей страницы пагинации
                $urlCurPage=$formData['url'].$formData['urlPage'];
                $url=$urlCurPage;
            }
            //--------

            return response()->json(['url' => $url, 'parentId' => $formData['parentId']]);

        }catch (Exception $exception){
            $errors=$exception->getMessage();
            return response()->json(['error' => $errors]);
        }



    }
}
