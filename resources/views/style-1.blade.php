<meta name="csrf-token" content="{{ csrf_token() }}">

@php
    $data = json_decode($content);
    $array_reation = ['like', 'love', 'haha', 'wow', 'sad', 'angry'];

@endphp

    <div class="dw-reactions-3" style="padding-top: 20px" id="vig-reaction"
            data-total="0"
            data-id="{{ $data->reference_id }}"
            data-type="{{ $data->reference_type }}">
        @foreach($array_reation as $reaction)
            <div class="dw-reactions-box-3">
                <div class="box-reaction">
                    <div class="dw-reactions-percent" id="vig-percent-{{ $reaction }}">
                        <div class="dw-reactions-count-3" id="vig-reaction-{{ $reaction }}" data-count="0">0</div>
                    </div>
                </div>

                <div class="dw-reactions-icon vigreaction" data-type="{{ $reaction }}">
                    <img src="vendor/core/plugins/vig-reactions/icon/{{ $reaction }}-a.gif" alt="{{ $reaction }}" height="80px">
                </div>
            </div>
        @endforeach
    </div>

@php
    Theme::asset()
             ->add('vig-reaction', 'vendor/core/plugins/vig-reactions/style-1/style.css', [], [], '1.1.1');
    Theme::asset()
            ->container('footer')
            ->add('vig-reaction', 'vendor/core/plugins/vig-reactions/style-1/scripts.js', [], [], '1.1.0');
@endphp
