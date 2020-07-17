

<meta name="csrf-token" content="{{ csrf_token() }}">

@php
    $reactions  = get_vig_reaction($content);
    $like       = count_vig_reaction($reactions, 'like');
    $love       = count_vig_reaction($reactions, 'love');
    $haha       = count_vig_reaction($reactions, 'haha');
    $wow        = count_vig_reaction($reactions, 'wow');
    $sad        = count_vig_reaction($reactions, 'sad');
    $angry      = count_vig_reaction($reactions, 'angry');
    $total      = count_vig_reaction($reactions);
@endphp

<div class="dw-reactions-3"
        id="vig-reaction"
        data-id="{{ $reactions->first()->reaction_id }}"
        data-type="{{ $reactions->first()->reaction_type }}"
        data-total="{{ $total }}" data-session="{{ Session::getId() }}">
    <div class="dw-reactions-box-3">
        <div class="box-reaction">
            <div class="dw-reactions-percent" id="vig-percent-like">
                <div class="dw-reactions-count-3" id="vig-reaction-like" data-count="{{ $like }}">{{ $like }}</div>
            </div>
        </div>

        <div class="dw-reactions-icon vigreaction" data-type="like">
            <img src="vendor/core/plugins/vig-reactions/icon/like-a.gif" alt="like" height="80px">
        </div>
    </div>

    <div class="dw-reactions-box-3">
        <div class="box-reaction">
            <div class="dw-reactions-percent" id="vig-percent-love">
                <div class="dw-reactions-count-3" id="vig-reaction-love" data-count="{{ $love }}">{{ $love }}</div>
            </div>
        </div>

        <div class="dw-reactions-icon vigreaction" data-type="love">
            <img src="vendor/core/plugins/vig-reactions/icon/love-a.gif" alt="love" height="80px">
        </div>
    </div>

    <div class="dw-reactions-box-3">
        <div class="box-reaction">
            <div class="dw-reactions-percent" id="vig-percent-haha">
                <div class="dw-reactions-count-3" id="vig-reaction-haha" data-count="{{ $haha }}">{{ $haha }}</div>
            </div>
        </div>
        <div class="dw-reactions-icon vigreaction" data-type="haha">
            <img src="vendor/core/plugins/vig-reactions/icon/haha-a.gif" alt="haha" height="80px">
        </div>
    </div>

    <div class="dw-reactions-box-3">
        <div class="box-reaction">
            <div class="dw-reactions-percent" id="vig-percent-wow">
                <div class="dw-reactions-count-3" id="vig-reaction-wow" data-count="{{ $wow }}">{{ $wow }}</div>
            </div>
        </div>

        <div class="dw-reactions-icon vigreaction" data-type="wow">
            <img src="vendor/core/plugins/vig-reactions/icon/wow-a.gif" alt="wow" height="80px">
        </div>
    </div>

    <div class="dw-reactions-box-3">
        <div class="box-reaction">
            <div class="dw-reactions-percent" id="vig-percent-sad">
                <div class="dw-reactions-count-3" id="vig-reaction-sad" data-count="{{ $sad }}">{{ $sad }}</div>
            </div>
        </div>

        <div class="dw-reactions-icon vigreaction" data-type="sad">
            <img src="vendor/core/plugins/vig-reactions/icon/sad-a.gif" alt="sad" height="80px">
        </div>
    </div>

    <div class="dw-reactions-box-3">
        <div class="box-reaction">
            <div class="dw-reactions-percent" id="vig-percent-angry">
                <div class="dw-reactions-count-3" id="vig-reaction-angry" data-count="{{ $angry }}">{{ $angry }}</div>
            </div>
        </div>

        <div class="dw-reactions-icon vigreaction" data-type="angry">
            <img src="vendor/core/plugins/vig-reactions/icon/angry-a.gif" alt="angry" height="80px">
        </div>
    </div>
</div>


@php

    Theme::asset()
             ->add('vig-reaction', 'vendor/core/plugins/vig-reactions/vig-reaction.min.v1.css', [], [], '1.1.0');
    Theme::asset()
            ->container('footer')
            ->add('vig-reaction', 'vendor/core/plugins/vig-reactions/vig-reaction.min.v1.js', [], [], '1.1.0');
@endphp
