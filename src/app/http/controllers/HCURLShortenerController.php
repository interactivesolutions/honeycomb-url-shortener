<?php namespace interactivesolutions\honeycomburlshortener\app\http\controllers;

use DB;
use Illuminate\Database\Eloquent\Builder;
use InteractiveSolutions\HoneycombCore\Http\Controllers\HCBaseController;
use interactivesolutions\honeycomburlshortener\app\models\HCShortURL;
use interactivesolutions\honeycomburlshortener\app\validators\HCURLShortenerValidator;

class HCURLShortenerController extends HCBaseController
{

    /**
     * Returning configured admin view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminIndex()
    {
        $config = [
            'title' => trans('HCURLShortener::url_shortener.page_title'),
            'listURL' => route('admin.api.url.shortener'),
            'newFormUrl' => route('admin.api.form-manager', ['url-shortener-new']),
            'editFormUrl' => route('admin.api.form-manager', ['url-shortener-edit']),
            //    'imagesUrl'   => route('resource.get', ['/']),
            'headers' => $this->getAdminListHeader(),
        ];

        if (auth()->user()->can('interactivesolutions_honeycomb_url_shortener_url_shortener_create')) {
            $config['actions'][] = 'new';
        }

        if (auth()->user()->can('interactivesolutions_honeycomb_url_shortener_url_shortener_update')) {
            $config['actions'][] = 'update';
            $config['actions'][] = 'restore';
        }

        if (auth()->user()->can('interactivesolutions_honeycomb_url_shortener_url_shortener_delete')) {
            $config['actions'][] = 'delete';
        }

        $config['actions'][] = 'search';

        return hcview('HCCoreUI::admin.content.list', ['config' => $config]);
    }

    /**
     * Creating Admin List Header based on Main Table
     *
     * @return array
     */
    public function getAdminListHeader()
    {
        return [
            'url' => [
                "type" => "text",
                "label" => trans('HCURLShortener::url_shortener.url'),
            ],
            'short_url_key' => [
                "type" => "text",
                "label" => trans('HCURLShortener::url_shortener.short_url_key'),
            ],
            'clicks' => [
                "type" => "text",
                "label" => trans('HCURLShortener::url_shortener.clicks'),
            ],

        ];
    }

    /**
     * Create item
     *
     * @param null $data
     * @return mixed
     */
    protected function __apiStore(array $data = null)
    {
        if (is_null($data)) {
            $data = $this->getInputData();
        }

        return generateHCShortURL(array_get($data, 'record.url'), array_get($data, 'record.description'), true);
    }

    /**
     * Updates existing item based on ID
     *
     * @param $id
     * @return mixed
     */
    protected function __apiUpdate(string $id)
    {
        $record = HCShortURL::findOrFail($id);

        $data = $this->getInputData();

        $record->update(array_get($data, 'record'));

        return $this->apiShow($record->id);
    }

    /**
     * Delete records table
     *
     * @param $list
     * @return mixed
     */
    protected function __apiDestroy(array $list)
    {
        HCShortURL::destroy($list);

        return hcSuccess();
    }

    /**
     * Delete records table
     *
     * @param $list
     * @return mixed
     */
    protected function __apiForceDelete(array $list)
    {
        HCShortURL::onlyTrashed()->whereIn('id', $list)->forceDelete();

        return hcSuccess();
    }

    /**
     * Restore multiple records
     *
     * @param $list
     * @return mixed
     */
    protected function __apiRestore(array $list)
    {
        HCShortURL::whereIn('id', $list)->restore();

        return hcSuccess();
    }

    /**
     * Creating data query
     *
     * @param array $select
     * @return mixed
     */
    protected function createQuery(array $select = null)
    {
        $with = [];

        if ($select == null) {
            $select = HCShortURL::getFillableFields();
        }

        $list = HCShortURL::with($with)->select($select)
            // add filters
            ->where(function($query) use ($select) {
                $query = $this->getRequestParameters($query, $select);
            });

        // enabling check for deleted
        $list = $this->checkForDeleted($list);

        // add search items
        $list = $this->search($list);

        // ordering data
        $list = $this->orderData($list, $select);

        return $list;
    }

    /**
     * List search elements
     * @param Builder $query
     * @param string $phrase
     * @return Builder
     */
    protected function searchQuery(Builder $query, string $phrase)
    {
        return $query->where(function(Builder $query) use ($phrase) {
            $query->where('url', 'LIKE', '%' . $phrase . '%')
                ->orWhere('short_url_key', 'LIKE', '%' . $phrase . '%')
                ->orWhere('clicks', 'LIKE', '%' . $phrase . '%')
                ->orWhere('url', 'LIKE', '%' . $phrase . '%');
        });
    }

    /**
     * Getting user data on POST call
     *
     * @return mixed
     */
    protected function getInputData()
    {
        (new HCURLShortenerValidator())->validateForm();

        $_data = request()->all();

        array_set($data, 'record.url', array_get($_data, 'url'));
        array_set($data, 'record.description', array_get($_data, 'description'));

        return $data;
    }

    /**
     * Getting single record
     *
     * @param $id
     * @return mixed
     */
    public function apiShow(string $id)
    {
        $with = [];

        $select = HCShortURL::getFillableFields();

        $record = HCShortURL::with($with)
            ->select($select)
            ->where('id', $id)
            ->firstOrFail();

        return $record;
    }

    /**
     * Redirecting short URL to original URL
     *
     * @param $shortURLKey
     * @return Redirect
     */
    public function redirect(string $shortURLKey)
    {
        $record = HCShortURL::where('short_url_key', $shortURLKey)->first();

        if (!$record) {
            abort(404);
        }

        $record->increment('clicks');

        return redirect($record->url);
    }
}
