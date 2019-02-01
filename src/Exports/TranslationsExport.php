<?php

namespace Brackets\AdminTranslations\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Brackets\AdminTranslations\Translation;
use Illuminate\Support\Facades\Auth;
use Brackets\Translatable\Facades\Translatable;

class TranslationsExport implements FromCollection, WithMapping, WithHeadings
{

    private $exportLanguage;

    public function __construct($request)
    {
        $this->exportLanguage = $request->exportLanguage;
        $this->templateLanguage = $request->templateLanguage;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Translation::all();
    }

    public function headings(): array
    {
        $headings = [
            trans('brackets/admin-translations::admin.fields.namespace'),
            trans('brackets/admin-translations::admin.fields.group'),
            trans('brackets/admin-translations::admin.fields.default'),
        ];

        if($this->templateLanguage != ''){
            array_push($headings,  'reference' . mb_strtoupper($this->templateLanguage));
        };

        array_push($headings, mb_strtoupper($this->exportLanguage));

        return $headings;
    }

    /**
     * @param Translation $translation
     * @return array
     *
     */

    public function map($translation): array
    {
        $map = [
            $translation->namespace,
            $translation->group,
            $translation->key,
        ];

        if($this->templateLanguage != ''){
            array_push($map, $this->getCurrentTransForTranslationLanguage($translation, $this->templateLanguage));
        }

        array_push($map, $this->getCurrentTransForTranslationLanguage($translation, $this->exportLanguage));

        return $map;
    }

    private function getCurrentTransForTranslationLanguage($translation, $language) {
        if($translation->group === "*"){
           return __($translation->key, [], $language);
        } else if($translation->namespace === "*"){
            return trans($translation->group.'.'.$translation->key, [], $language);
        } else {
            return trans(stripslashes($translation->namespace) . '::' . $translation->group . '.' . $translation->key, [], $language);
        }
    }
}