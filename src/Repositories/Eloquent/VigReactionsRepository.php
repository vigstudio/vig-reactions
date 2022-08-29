<?php

namespace Botble\VigReactions\Repositories\Eloquent;

use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;
use Botble\VigReactions\Repositories\Interfaces\VigReactionsInterface;
use Illuminate\Support\Arr;

class VigReactionsRepository extends RepositoriesAbstract implements VigReactionsInterface
{
    public function advancedGetReaction(array $params = [])
    {
        $params = array_merge([
            'condition' => [],
            'order_by'  => [],
            'group_by'  => [],
            'take'      => null,
            'paginate'  => [
                'per_page'      => null,
                'current_paged' => 1,
            ],
            'select'    => ['*'],
            'with'      => [],
            'withCount' => [],
            'withAvg'   => [],
        ], $params);

        $this->applyConditions($params['condition']);

        $data = $this->model->has('reactable');

        if ($params['select']) {
            $data = $data->select($params['select']);
        }

        foreach ($params['order_by'] as $column => $direction) {
            if (!in_array(strtolower($direction), ['asc', 'desc'])) {
                continue;
            }

            if ($direction !== null) {
                $data = $data->orderBy($column, $direction);
            }
        }

        foreach ($params['group_by'] as $column) {
            if ($column !== null) {
                $data = $data->groupBy($column);
            }
        }


        if (!empty($params['with'])) {
            $data = $data->with($params['with']);
        }

        if (!empty($params['withCount'])) {
            $data = $data->withCount($params['withCount']);
        }

        if (!empty($params['withAvg'])) {
            $data = $data->withAvg($params['withAvg'][0], $params['withAvg'][1]);
        }

        if ($params['take'] == 1) {
            $result = $this->applyBeforeExecuteQuery($data, true)->first();
        } elseif ($params['take']) {
            $result = $this->applyBeforeExecuteQuery($data)->take((int)$params['take'])->get();
        } elseif ($params['paginate']['per_page']) {
            $paginateType = 'paginate';

            if (Arr::get($params, 'paginate.type') && method_exists($data, Arr::get($params, 'paginate.type'))) {
                $paginateType = Arr::get($params, 'paginate.type');
            }

            $result = $this->applyBeforeExecuteQuery($data)
                ->$paginateType(
                    (int)Arr::get($params, 'paginate.per_page', 10),
                    [$this->originalModel->getTable() . '.' . $this->originalModel->getKeyName()],
                    'page',
                    (int)Arr::get($params, 'paginate.current_paged', 1)
                );
        } else {
            $result = $this->applyBeforeExecuteQuery($data)->get();
        }



        return $result;
    }
}
