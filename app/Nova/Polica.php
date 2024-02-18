<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Polica extends Resource
{
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('current_stage', \App\Models\Order::STAGE_FIVE);
    }
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Order>
     */
    public static $model = \App\Models\Order::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Code','code')->readonly(),
            BelongsTo::make('Client','client',Client::class)->readonly(),
            BelongsTo::make('Product','product',Product::class)->readonly(),
            HasMany::make('Product','product',Product::class)->readonly(),
            Text::make('Name of Company','polica_name'),
            Text::make('Telex Number','polica_number_telex'),
            Text::make('Polica Number Of Delivery','polica_number_of_delivery'),
            Text::make('Port','polica_port'),
            File::make('Quotes','file')
                ->store(function (Request $request, $model) {
                    $file = $request->file('polica_file');
                    $path = $file->store('POLisa', 'public');
                    $model->file = $path;
                    $model->save();
                    return [
                        'polica_file' => $path,
                    ];
                })
                ->prunable(),

        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
