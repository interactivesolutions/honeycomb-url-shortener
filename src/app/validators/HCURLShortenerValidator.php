<?php namespace interactivesolutions\honeycomburlshortener\app\validators;

use interactivesolutions\honeycombcore\http\controllers\HCCoreFormValidator;

class HCURLShortenerValidator extends HCCoreFormValidator
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'url' => 'url|required',
        ];
    }
}