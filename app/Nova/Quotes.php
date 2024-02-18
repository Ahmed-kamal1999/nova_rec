<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\File;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class Quotes extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Quotes>
     */
    public static $model = \App\Models\Quotes::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'code';

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
            BelongsTo::make('Order','order',Order::class)->hideWhenCreating()->hideWhenUpdating()->hideFromDetail(),
            Text::make('Amount','amount'),
            File::make('Quotes','file')
                ->store(function (Request $request, $model) {
                    $file = $request->file('file');
                    $path = $file->store('Quotes', 'public');
                    $model->file = $path;
                    $model->save();
                    return [
                        'file' => $path,
                    ];
                })
                ->prunable(),
            Select::make('Status')->options([
                '1' => 'APROVIED',
                '0' => 'Not APROVIED',
            ])->displayUsingLabels()->readonly(),
            HasMany::make('Product Quotes','productquotes',ProductQuotes::class)



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
        return [
            (new Actions\QuotesAgreement())
                ->withName('Select Qutions')
                ->confirmText('هل تريد فعلا إرجاع الطلب الى الحالة السابقة؟')
                ->confirmButtonText('تأكيد')
                ->cancelButtonText("إلغاء"),
        ];
    }
}
