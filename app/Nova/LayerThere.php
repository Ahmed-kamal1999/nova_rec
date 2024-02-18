<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class LayerThere extends Resource
{
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('current_stage', \App\Models\Order::STAGE_THERE);
    }
    public static function authorizedToViewAny(Request $request)
    {
        return optional($request->user())->hasPermissionTo('management Layer There');
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
            BelongsTo::make('Client','client',Client::class),
            HasMany::make('Product','product',Product::class),
            HasMany::make('Quotes','quotes',Quotes::class),
            HasMany::make('Product','product',Product::class),
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
            (new Actions\ApproveRequest())
                ->withName('ارسال الطلب')
                ->confirmText('هل تريد فعلا إرجاع الطلب الى الحالة السابقة؟')
                ->confirmButtonText('تأكيد')
                ->cancelButtonText("إلغاء"),
            (new Actions\PreviousStatusAction())
                ->withName('إرجاع الطلب')
                ->confirmText('هل تريد فعلا إرجاع الطلب الى الحالة السابقة؟')
                ->confirmButtonText('تأكيد')
                ->cancelButtonText("إلغاء"),


        ];
    }
}
