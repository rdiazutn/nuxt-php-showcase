<?php

namespace App\Nova;

use App\Modules\Tax\Models\TaxPeriod;
use App\Modules\Tax\Models\TaxPeriodStatus;
use App\Modules\Tax\Presentation\Models\PaymentMethodType;
use App\Modules\Tax\Presentation\Models\TaxPresentation;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class TaxPresentationNovaResource extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = TaxPresentation::class;

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

    public static $displayInNavigation = false;

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            DateTime::make('Created At')->onlyOnDetail(),
            DateTime::make('Updated At')->onlyOnDetail(),
            Select::make('Payment Method')
                ->options(PaymentMethodType::asSelectArray())
                ->displayUsingLabels(),
            BelongsTo::make('Tax Period', 'taxPeriod'),
            Number::make('Amount')
                ->rules('required', 'min:0'),
            Number::make('Balance')->default(0)
                ->rules('required', 'min:0'),
            Number::make('Used Balance')->default(0)
                ->rules('required', 'min:0'),
            Text::make('Comment')->nullable()->rules('max:1024'),
            Date::make('Voucher Expiration Date')->nullable(),
            Date::make('Voucher Generation Date')->nullable(),
            BelongsTo::make('Draft', 'draft', FileNovaResource::class),
            BelongsTo::make('Voucher', 'voucher', FileNovaResource::class)->nullable(),
            BelongsTo::make('Presentation', 'presentation', FileNovaResource::class)->nullable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
