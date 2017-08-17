<?php

return [

    /*
     * Language lines will be fetched by these loaders. You can put any class here that implements
     * the Brackets\AdminTranslations\TranslationLoaders\TranslationLoader-interface.
     */
    'translation_loaders' => [
        Brackets\AdminTranslations\TranslationLoaders\Db::class,
    ],

    /*
     * This is the model used by the Db Translation loader. You can put any model here
     * that extends Brackets\AdminTranslations\Translation.
     */
    'model' => Brackets\AdminTranslations\Translation::class,

    /*
     * This option controls if package routes are used or not
     */
    'use-routes' => true,

];