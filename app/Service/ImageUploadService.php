<?php

namespace App\Service;

use Intervention\Image\ImageManagerStatic as Image;

class ImageUploadService
{

    public static function upload_user_image($image)
    {
        $extention = $image->getClientOriginalExtension();
        $image_name_to_save = uniqid('user_') . time() . '.' . $extention;
        $img = Image::make($image)->orientate();
        $size = min(1000, $img->width());
        $img = Image::make($image)->orientate()->resize($size, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $csize = min($img->width(), $img->height());
        $img->crop($csize, $csize)->save(storage_path('app/public/user/image/' . $image_name_to_save));
        return $image_name_to_save;
    }

    public static function upload_project_image($image)
    {
        $extention = $image->getClientOriginalExtension();
        $image_name_to_save = uniqid('project_') . time() . '.' . $extention;
        $img = Image::make($image)->orientate();
        $size = min(1000, $img->width());
        $img = Image::make($image)->orientate()->resize($size, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $csize = min($img->width(), $img->height());
        $img->crop($csize, $csize)->save(storage_path('app/public/project/image/' . $image_name_to_save));
        return $image_name_to_save;
    }

    public static function upload_design_image($image)
    {
        $extention = $image->getClientOriginalExtension();
        $image_name_to_save = uniqid('design_') . time() . '.' . $extention;
        $img = Image::make($image)->orientate();
        $size = min(1000, $img->width());
        $img = Image::make($image)->orientate()->resize($size, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $csize = min($img->width(), $img->height());
        $img->crop($csize, $csize)->save(storage_path('app/public/project/borehole/image/' . $image_name_to_save));
        return $image_name_to_save;
    }
}
