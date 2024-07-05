<?php

namespace App\Services\admin;

use App\Models\Gallery;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ImageService {

    public function getImg() {
        if (session()->has('single')) {
            $this->attributes['img'] = session()->pull('single');
        }
    }

    public function saveGallery($id) {
        if (session()->has('multi')) {
            $images = session()->pull('multi');
            $data = array_map(function ($image) use ($id) {
                return ['img' => $image, 'product_id' => $id];
            }, $images);
            DB::table('gallery')->insert($data);
        }
    }

    public function uploadImg($name, $wmax, $hmax,$file) {
        if($file->isValid()) {
            $uploaddir = public_path('images/');
            $ext = $file->getClientOriginalExtension();
            $types = ['gif', 'png', 'jpeg', 'jpg'];

            if ($file->getSize() > 1048576) {
                return Response::json(['error' => 'Ошибка! Максимальный вес файла - 1 Мб!'], 400);
            }

            if (!in_array($ext, $types)) {
                return Response::json(['error' => 'Допустимые расширения - .gif, .jpg, .png'], 400);
            }

            $new_name = md5(time()) . ".$ext";
            $uploadfile = $uploaddir . $new_name;

            $file->move($uploaddir, $new_name);

            if ($name == 'single') {
                session()->put('single', $new_name);
            } else {
                session()->push('multi', $new_name);
            }

            try {
                self::resize($uploadfile, $uploadfile, $wmax, $hmax, $ext);
            }
            catch(\Exception $e){
                Response::json(['error' => 'Ошибка загрузки файла!'], 400);
            }

            return Response::json(['file' => $new_name]);
        }
        return Response::json(['error' => 'Ошибка загрузки файла!'], 400);
    }


    /**
     * @param string $target путь к оригинальному файлу
     * @param string $dest путь сохранения обработанного файла
     * @param string $wmax максимальная ширина
     * @param string $hmax максимальная высота
     * @param string $ext расширение файла
     */
    public static function resize($target, $dest, $wmax, $hmax, $ext) {
        list($w_orig, $h_orig) = getimagesize($target);
        $ratio = $w_orig / $h_orig;

        if (($wmax / $hmax) > $ratio) {
            $wmax = $hmax * $ratio;
        } else {
            $hmax = $wmax / $ratio;
        }

        $img = match ($ext) {
            'gif' => imagecreatefromgif($target),
            'png' => imagecreatefrompng($target),
            default => imagecreatefromjpeg($target),
        };

        $newImg = imagecreatetruecolor($wmax, $hmax);

        if ($ext == "png") {
            imagesavealpha($newImg, true);
            $transPng = imagecolorallocatealpha($newImg, 0, 0, 0, 127);
            imagefill($newImg, 0, 0, $transPng);
        }

        imagecopyresampled($newImg, $img, 0, 0, 0, 0, $wmax, $hmax, $w_orig, $h_orig);

        match ($ext) {
            'gif' => imagegif($newImg, $dest),
            'png' => imagepng($newImg, $dest),
            default => imagejpeg($newImg, $dest),
        };

        imagedestroy($newImg);
    }

    public function clear(){
        $multi = session()->get("multi");
        if(isset($multi)){
            foreach ($multi as $key){
                unlink(public_path("images/{$key}"));
            }
        }

        $single = session()->get("single");
        if(isset($single)){
            unlink(public_path("images/{$single}"));
        }

        session()->forget("multi");
        session()->forget("single");
    }

    public function insetrGalery($productId){
        if($productId){
            $images= session()->get("multi");

            if($images){
                $imageData = [];
                foreach ($images as $image) {
                    $imageData[] = ['img' => $image, 'product_id' => $productId];
                }

                Gallery::insert($imageData);
            }

            $img = session()->get("single");
            if($img){
                $product = Product::where("id","=",$productId)->first();
                $product->img = $img;
                $product->save();
            }

            session()->forget("multi");
            session()->forget("single");
        }
    }
}
