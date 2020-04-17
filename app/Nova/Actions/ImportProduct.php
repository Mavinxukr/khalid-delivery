<?php

namespace App\Nova\Actions;


use App\Nova\Imports\ProductImport;
use App\Nova\Resources\Category\MenuCategory;
use App\Nova\Resources\Provider\Provider;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\File;
use Excel;
use Sloveniangooner\SearchableSelect\SearchableSelect;

class ImportProduct extends Action
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */

    public $onlyOnIndex = true;

    public function name() {
        return __('Import Product');
    }

    public function uriKey() :string
    {
        return 'import-menu';
    }

    public function handle(ActionFields $fields, Collection $models)
    {
        Excel::import(new ProductImport($fields->provider_id,$fields->category_id), $fields->file);
        return Action::message('Success !');
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            File::make('File')
                ->rules('required')
                ->help("Only file .xls"),
            SearchableSelect::make('Provider','provider_id')
                ->resource(Provider::class)
                ->help("Need chose provider")
                ->displayUsingLabels()
                ->nullable()
                ->rules('required'),
            SearchableSelect::make('Category','category_id')
                ->resource(MenuCategory::class)
                ->help("Need chose category")
                ->displayUsingLabels()
                ->nullable()
        ];
    }
}
