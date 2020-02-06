<?php

namespace App\Classes\Services;

use App\Message;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class MessageService
{
    // Класс для работы с моделью Message БД: Добавить запись, удалить, редактировать, выбрать данные
    public static function create($textMessage, $parentId=0, $path=null)
    {
        $msg = new Message();
        $msg->text = $textMessage;
        $msg->author_id = Auth::id();
        $msg->parent_id = $parentId;
        $msg->images = $path;

        $created = $msg->save();
        return $created;
    }

    public static function getAll()
    {
        $allMsgs=Message::join('users', 'author_id','=','users.id')
            ->select('users.email', 'messages.*')
            ->orderBy('messages.created_at', 'asc')
            ->get();
        return $allMsgs;
    }

    public static function getPaginated($url)
    {
        //данный метод осуществляет пагинацию вручную


        // получеаем все дерево сообщений
        $allMsgs=  self::getMsgTree();
        // Get current page from url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        // Create a new Laravel collection from the array data
        // выбираем только родительские сообщения (корневые, которые не содержат ответов)
        $parentsOnlyMsgs = collect($allMsgs)->where('parent_id',0);;
        // Define how many items we want to be visible in each page
        $perPage = 25;
        // Slice the collection to get the items to display in current page
        $currentPageItems = $parentsOnlyMsgs->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        // Create our paginator and pass it to the view
        $paginatedMsgs= new LengthAwarePaginator($currentPageItems , count($parentsOnlyMsgs), $perPage);
        // set url path for generated links
        $paginatedMsgs->setPath($url);

        return $paginatedMsgs;
    }

    public static function getMsgTree()
    {
        $arr=self::getAll();
        $parentsArr = array();
        foreach ($arr as $key => $item){
            $parentsArr[$item['parent_id']][$item['id']] = $item;
        }

        $treeElem=$parentsArr[0];
        self::generateElemTree($treeElem, $parentsArr);

        return $treeElem;
    }

    public static function generateElemTree($treeElem, $parentsArr)
    {
        foreach ($treeElem as $key => $item){
            if (!isset($item['children'])){
                $treeElem[$key]['children'] = array();
            }
            if (array_key_exists($key, $parentsArr)){
                $treeElem[$key]['children'] = $parentsArr[$key];
                self::generateElemTree($treeElem[$key]['children'], $parentsArr);
            }
        }

    }


//    public static function update($inputData)
//    {
//        $msg = Message::find($inputData['id']);
//        $msg->text = $inputData['message'];
//        $msg->images = $inputData['customFile'];
//        $updated=$msg->save();
//        return $updated;
//    }
}
