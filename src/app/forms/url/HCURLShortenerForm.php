<?php

namespace interactivesolutions\honeycomburlshortener\forms;

class HCURLShortenerForm
{
    // name of the form
    protected $formID = 'url-shortener';

    // is form multi language
    protected $multiLanguage = 0;

    /**
     * Creating form
     *
     * @param bool $edit
     * @return array
     */
    public function createForm($edit = false)
    {
        $form = [
            'storageURL' => route('admin.api.url.shortener'),
            'buttons'    => [
                [
                    "class" => "col-centered",
                    "label" => trans('HCCoreUI::core.button.submit'),
                    "type"  => "submit",
                ],
            ],
            'structure'  => [
                [
                    "type"            => "singleLine",
                    "fieldID"         => "url",
                    "label"           => trans("HCURLShortener::url_shortener.url"),
                    "required"        => 1,
                    "requiredVisible" => 1,
                ],
                [
                    "type"            => "richTextArea",
                    "fieldID"         => "description",
                    "label"           => trans("HCURLShortener::url_shortener.description"),
                ]
            ],
        ];

        if ($this->multiLanguage)
            $form['availableLanguages'] = []; //TOTO implement honeycomb-languages package

        if (!$edit)
            return $form;

        //Make changes to edit form if needed
        // $form['structure'][] = [];

        return $form;
    }
}