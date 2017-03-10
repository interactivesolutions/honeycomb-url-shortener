<?php namespace interactivesolutions\honeycomburlshortener\app\http\controllers;

use DB;
use Illuminate\Database\Eloquent\Builder;
use interactivesolutions\honeycombcore\http\controllers\HCBaseController;
use interactivesolutions\honeycomburlshortener\app\models\HCShortURL;
use interactivesolutions\honeycomburlshortener\app\validators\HCURLShortenerValidator;

class HCURLShortenerController extends HCBaseController
{

    /**
     * Returning configured admin view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminView()
    {
        $config = [
            'title'       => trans('HCURLShortener::url_shortener.page_title'),
            'listURL'     => route('admin.api.url.shortener'),
            'newFormUrl'  => route('admin.api.form-manager', ['url-shortener-new']),
            'editFormUrl' => route('admin.api.form-manager', ['url-shortener-edit']),
            //    'imagesUrl'   => route('resource.get', ['/']),
            'headers'     => $this->getAdminListHeader(),
        ];

        if ($this->user()->can('interactivesolutions_honeycomb_url_shortener_url_shortener_create'))
            $config['actions'][] = 'new';

        if ($this->user()->can('interactivesolutions_honeycomb_url_shortener_url_shortener_update')) {
            $config['actions'][] = 'update';
            $config['actions'][] = 'restore';
        }

        if ($this->user()->can('interactivesolutions_honeycomb_url_shortener_url_shortener_delete'))
            $config['actions'][] = 'delete';

        $config['actions'][] = 'search';

        return view('HCCoreUI::admin.content.list', ['config' => $config]);
    }

    /**
     * Creating Admin List Header based on Main Table
     *
     * @return array
     */
    public function getAdminListHeader()
    {
        return [
            'url'           => [
                "type"  => "text",
                "label" => trans('HCURLShortener::url_shortener.url'),
            ],
            'short_url_key' => [
                "type"  => "text",
                "label" => trans('HCURLShortener::url_shortener.short_url_key'),
            ],
            'clicks'        => [
                "type"  => "text",
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
    protected function __create(array $data = null)
    {
        if (is_null($data))
            $data = $this->getInputData();

        return generateHCShortURL(array_get($data, 'record.url'), array_get($data, 'record.description'), true);
    }

    /**
     * Updates existing item based on ID
     *
     * @param $id
     * @return mixed
     */
    protected function __update(string $id)
    {
        $record = HCShortURL::findOrFail($id);

        $data = $this->getInputData();

        $record->update(array_get($data, 'record'));

        return $this->getSingleRecord($record->id);
    }

    /**
     * Delete records table
     *
     * @param $list
     * @return mixed|void
     */
    protected function __delete(array $list)
    {
        HCShortURL::destroy($list);
    }

    /**
     * Delete records table
     *
     * @param $list
     * @return mixed|void
     */
    protected function __forceDelete(array $list)
    {
        HCShortURL::onlyTrashed()->whereIn('id', $list)->forceDelete();
    }

    /**
     * Restore multiple records
     *
     * @param $list
     * @return mixed|void
     */
    protected function __restore(array $list)
    {
        HCShortURL::whereIn('id', $list)->restore();
    }

    /**
     * Creating data query
     *
     * @param array $select
     * @return mixed
     */
    public function createQuery(array $select = null)
    {
        $with = [];

        if ($select == null)
            $select = HCShortURL::getFillableFields();

        $list = HCShortURL::with($with)->select($select)
            // add filters
            ->where(function ($query) use ($select) {
                $query = $this->getRequestParameters($query, $select);
            });

        // enabling check for deleted
        $list = $this->checkForDeleted($list);

        // add search items
        $list = $this->listSearch($list);

        // ordering data
        $list = $this->orderData($list, $select);

        return $list;
    }



    /**
     * List search elements
     * @param $list
     * @return mixed
     */
    protected function listSearch(Builder $list)
    {
        if (request()->has('q')) {
            $parameter = request()->input('q');

            $list = $list->where(function ($query) use ($parameter) {
                $query->where('url', 'LIKE', '%' . $parameter . '%')
                    ->orWhere('short_url_key', 'LIKE', '%' . $parameter . '%')
                    ->orWhere('clicks', 'LIKE', '%' . $parameter . '%');
            });
        }

        return $list;
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
    public function getSingleRecord(string $id)
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

        if (!$record)
            abort(404);

        DB::table(HCShortURL::getTableName())->where('short_url_key', $shortURLKey)->increment('clicks');

        return redirect($record->url);
    }
}
