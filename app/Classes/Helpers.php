<?php

namespace App\Classes;



use Intervention\Image\ImageManagerStatic as Image;

class Helpers
{
    // Класс для кастомных методов
    public static function resizeImg($pathImg, $toWidth, $toHeight)
    {
        //                ----------- изменяем размер файла пропорцинально исходным соотношениям сторон
        $img = Image::make($pathImg); // с помощью intervention создаем объект картинки
        if ($img->width()>$toWidth) {
            $img->resize($toWidth, null, function ($constraint) {
                // с помощью intervention изменяем размер картинки под ширину 500 с соблюдением начальных пропорций
                $constraint->aspectRatio();
            })->save(); //сохраняем измененный файл в то же место
        }
        if ($img->height()>$toHeight) {
            $img->resize(null, $toHeight, function ($constraint) {
                // с помощью intervention изменяем размер картинки под ширину 500 с соблюдением начальных пропорций
                $constraint->aspectRatio();
            })->save(); //сохраняем измененный файл в то же место
        }
        return $pathImg;
    }


}
