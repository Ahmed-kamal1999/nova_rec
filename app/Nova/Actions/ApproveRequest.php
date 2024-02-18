<?php

namespace App\Nova\Actions;

use App\Models\Order;
use App\Models\RequestStageHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;use function Symfony\Component\String\u;

class ApproveRequest extends Action
{
    use InteractsWithQueue, Queueable;
    public $withoutActionEvents = true;
    public $message = 'تمت الموافقة على الطلب بنجاح';
    public $isDangerMessage = false;
    public $prevent_increase_stage = false;


    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {

            RequestStageHistory::create([
                'old_stage' => $model->current_stage,
                'new_stage' => $model->current_stage + 1,
                'order_id' => $model->id,
                'user_id' => auth()->user()->id,
            ]);

            if (!$this->prevent_increase_stage){
                $model->increment('current_stage');
                $model->save();
            }


        }

        $result = Action::{ $this->isDangerMessage ? 'danger' : 'message' }($this->message);

        if (!$this->isDangerMessage){
            $result->withRedirect('/cpanel/resources/' . \request()->route('resource'));
        }

        return $result;

    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
