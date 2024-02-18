<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class ChinaReceipt extends Resource
{

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('statusofwork', \App\Models\Order::China_receipt);
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
            BelongsTo::make('Product','product',Product::class),
            BelongsTo::make('Client','client',Client::class),
            HasMany::make('Product','product',Product::class),
            HasMany::make('Quotes','quotes',Quotes::class),
            Select::make('Status','statusofwork')->options([
                '0' => 'China Receipt',
                '1' => 'China In Processed',
            ])->displayUsingLabels()->readonly(),
            HasMany::make('history','history',StageHistory::class)
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
            (new Actions\UnderProcessing())
                ->withName('تحت المعالجة')
                ->confirmText('هل تريد فعلا إرجاع الطلب الى الحالة السابقة؟')
                ->confirmButtonText('تأكيد')
                ->cancelButtonText("إلغاء"),
        ];
    }
}
