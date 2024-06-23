<?php

namespace App\Services\admin;

use Illuminate\Support\Facades\DB;

class AliasService {

    public static function createAlias(string $table, string $field, string $str, int $id = 1): string {
        $str = self::str2url($str);
        $res = DB::table($table)->where($field, $str)->get();
        if ($res->count() > 0) {
            while (DB::table($table)->where($field, "$str-$id")->get()->count() > 0) {
                $id++;
            }
            $str = "$str-$id";
        }
        return $str;
    }

    private static function str2url(string $str): string {
        $str = self::rus2translit($str);
        $str = strtolower($str);
        $str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
        return trim($str, "-");
    }

    private static function rus2translit(string $string): string {

        $converter = array(

            'а' => 'a', 'б' => 'b', 'в' => 'v',

            'г' => 'g', 'д' => 'd', 'е' => 'e',

            'ё' => 'e', 'ж' => 'zh', 'з' => 'z',

            'и' => 'i', 'й' => 'y', 'к' => 'k',

            'л' => 'l', 'м' => 'm', 'н' => 'n',

            'о' => 'o', 'п' => 'p', 'р' => 'r',

            'с' => 's', 'т' => 't', 'у' => 'u',

            'ф' => 'f', 'х' => 'h', 'ц' => 'c',

            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',

            'ь' => '\'', 'ы' => 'y', 'ъ' => '\'',

            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',


            'А' => 'A', 'Б' => 'B', 'В' => 'V',

            'Г' => 'G', 'Д' => 'D', 'Е' => 'E',

            'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',

            'И' => 'I', 'Й' => 'Y', 'К' => 'K',

            'Л' => 'L', 'М' => 'M', 'Н' => 'N',

            'О' => 'O', 'П' => 'P', 'Р' => 'R',

            'С' => 'S', 'Т' => 'T', 'У' => 'U',

            'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',

            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',

            'Ь' => '\'', 'Ы' => 'Y', 'Ъ' => '\'',

            'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',

        );

        return strtr($string, $converter);

    }

}
