<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kouden extends Model
{
    use HasFactory;
    protected $fillable = ['name_kan', 'section'];


        /**
     * id: 一意(autoincrement) nounull 同じ値不可
     * section: tinyInteger (1〜255), notnull、名目（1:香典、2:御見舞、3:供物代、4:当日_見舞、5:新盆、6:初彼岸、7:春彼岸、8:1年忌
     * post: 所属
     * name_kan: 漢字氏名
     * relation: 続柄
     * address: 住所
     * price: 価格
     * created_at: 登録日
     * memo: メモ
     * */

    public const KOUDEN_SECTION_KOUDEN = 1;
    public const KOUDEN_SECTION_OMIMAI = 2;
    public const KOUDEN_SECTION_OSONAE = 3;
    public const KOUDEN_SECTION_JIZEN = 4;
    public const KOUDEN_SECTION_NIIBON = 5;
    public const KOUDEN_SECTION_HATUHIGAN = 6;
    public const KOUDEN_SECTION_HARUHIGAN = 7;
    public const KOUDEN_SECTION_ICHINENKI = 8;
    public const KOUDEN_SECTION_NINENOBON = 9;

    public const KOUDEN_SECTION_NAME_KOUDEN = '香典';
    public const KOUDEN_SECTION_NAME_OMIMAI = '御見舞';
    public const KOUDEN_SECTION_NAME_OSONAE = '供物代';
    public const KOUDEN_SECTION_NAME_JIZEN = '当日_見舞';
    public const KOUDEN_SECTION_NAME_NIIBON = '新盆';
    public const KOUDEN_SECTION_NAME_HATUHIGAN = '初彼岸';
    public const KOUDEN_SECTION_NAME_HARUHIGAN = '春彼岸';
    public const KOUDEN_SECTION_NAME_ICHINENKI = '1年忌';
    public const KOUDEN_SECTION_NAME_NINENOBON  = '2年目お盆';

    public const KOUDEN_SECTION_OBJECT = [
        self::KOUDEN_SECTION_KOUDEN => self::KOUDEN_SECTION_NAME_KOUDEN,
        self::KOUDEN_SECTION_OMIMAI => self::KOUDEN_SECTION_NAME_OMIMAI,
        self::KOUDEN_SECTION_OSONAE => self::KOUDEN_SECTION_NAME_OSONAE,
        self::KOUDEN_SECTION_JIZEN => self::KOUDEN_SECTION_NAME_JIZEN,
        self::KOUDEN_SECTION_NIIBON => self::KOUDEN_SECTION_NAME_NIIBON,
        self::KOUDEN_SECTION_HATUHIGAN => self::KOUDEN_SECTION_NAME_HATUHIGAN,
        self::KOUDEN_SECTION_HARUHIGAN => self::KOUDEN_SECTION_NAME_HARUHIGAN,
        self::KOUDEN_SECTION_ICHINENKI => self::KOUDEN_SECTION_NAME_ICHINENKI,
        self::KOUDEN_SECTION_NINENOBON => self::KOUDEN_SECTION_NAME_NINENOBON,
    ];

    public const KOUDEN_SECTION_ARRAY = [
        self::KOUDEN_SECTION_KOUDEN,
        self::KOUDEN_SECTION_OMIMAI,
        self::KOUDEN_SECTION_OSONAE,
        self::KOUDEN_SECTION_JIZEN,
        self::KOUDEN_SECTION_NIIBON,
        self::KOUDEN_SECTION_HATUHIGAN,
        self::KOUDEN_SECTION_HARUHIGAN,
        self::KOUDEN_SECTION_ICHINENKI,
        self::KOUDEN_SECTION_NINENOBON,
    ];

     public function scopeSearch($query, $search)
    {
        // $name = $search[''] ?? '';
        $section = $search['section'] ?? '';
        $name_kan = $search['name_kan'] ?? '';


        $query->when($section, function ($query, $section) {
            $query->where('section', $section);
        });

        $query->when($name_kan, function ($query, $name_kan) {
            $query->where('name_kan', 'like', "%$name_kan%");
        });

        return $query;
    }



}
