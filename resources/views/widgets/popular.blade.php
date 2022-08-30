@if ($reactions->count() > 0)
    <div class="scroller">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>{{ trans('plugins/vig-reactions::vig-reactions.type') }}</th>
                <th>{{ trans('plugins/vig-reactions::vig-reactions.name') }}</th>
                <th>{{ trans('plugins/vig-reactions::vig-reactions.count') }}</th>
                <th>{{ trans('core/base::tables.created_at') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reactions as $reaction)
                {{-- @dd( $reaction->meta_value) --}}
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{!! $reaction->type_image !!}</td>
                    <td>@if($reaction->reactable)<a href="{{ $reaction->reactable->url }}">{{ $reaction->reactable->name }}</a>@endif</td>
                    <td>{{ $reaction->value['reactable_total'] }}</td>
                    <td>{{ BaseHelper::formatDate($reaction->created_at, 'd-m-Y') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @if ($reactions instanceof Illuminate\Pagination\LengthAwarePaginator)
        <div class="widget_footer">
            @include('core/dashboard::partials.paginate', ['data' => $reactions, 'limit' => $limit])
        </div>
    @endif
@else
    @include('core/dashboard::partials.no-data', ['message' => 'Nothing'])
@endif
