

<meta name="csrf-token" content="{{ csrf_token() }}">
@php
    $like   = $reations->where('type', 'like')->count();
    $love   = $reations->where('type', 'love')->count();
    $haha   = $reations->where('type', 'haha')->count();
    $wow    = $reations->where('type', 'wow')->count();
    $sad    = $reations->where('type', 'sad')->count();
    $angry  = $reations->where('type', 'angry')->count();
    $total  = $reations->count();
@endphp
<div class="dw-reactions-3"
        id="vig-reaction"
        data-id="{{ $content[0] }}"
        data-type="{{ $content[1] }}"
        data-total="{{ $total }}">
    <div class="dw-reactions-box-3">
        <div class="dw-reactions-percent" id="vig-percent-like"></div>
        <div class="dw-reactions-count-3"
            id="vig-reaction-like"
            data-count="{{ $like }}">
            {{ $like }}
        </div>
        <div class="dw-reactions-icon vigreaction" data-type="like">
            <img src="vendor/core/plugins/vig-reactions/icon/like-a.gif" alt="like" height="80px">
        </div>
    </div>

    <div class="dw-reactions-box-3">
        <div class="dw-reactions-percent" id="vig-percent-love"></div>
        <div class="dw-reactions-count-3"
            id="vig-reaction-love"
            data-count="{{ $love }}">
            {{ $love }}
        </div>
        <div class="dw-reactions-icon vigreaction" data-type="love">
            <img src="vendor/core/plugins/vig-reactions/icon/love-a.gif" alt="love" height="80px">
        </div>
    </div>

    <div class="dw-reactions-box-3">
        <div class="dw-reactions-percent" id="vig-percent-haha"></div>
        <div class="dw-reactions-count-3"
            id="vig-reaction-haha"
            data-count="{{ $haha }}">
            {{ $haha }}
        </div>
        <div class="dw-reactions-icon vigreaction" data-type="haha">
            <img src="vendor/core/plugins/vig-reactions/icon/haha-a.gif" alt="haha" height="80px">
        </div>
    </div>

    <div class="dw-reactions-box-3">
        <div class="dw-reactions-percent" id="vig-percent-wow"></div>
        <div class="dw-reactions-count-3"
            id="vig-reaction-wow"
            data-count="{{ $wow }}">
            {{ $wow }}
        </div>
        <div class="dw-reactions-icon vigreaction" data-type="wow">
            <img src="vendor/core/plugins/vig-reactions/icon/wow-a.gif" alt="wow" height="80px">
        </div>
    </div>

    <div class="dw-reactions-box-3">
        <div class="dw-reactions-percent" id="vig-percent-sad"></div>
        <div class="dw-reactions-count-3"
            id="vig-reaction-sad"
            data-count="{{ $sad }}">
            {{ $sad }}
        </div>
        <div class="dw-reactions-icon vigreaction" data-type="sad">
            <img src="vendor/core/plugins/vig-reactions/icon/sad-a.gif" alt="sad" height="80px">
        </div>
    </div>

    <div class="dw-reactions-box-3">
        <div class="dw-reactions-percent" id="vig-percent-angry"></div>
        <div class="dw-reactions-count-3"
            id="vig-reaction-angry"
            data-count="{{ $angry }}">
            {{ $angry }}
        </div>
        <div class="dw-reactions-icon vigreaction" data-type="angry">
            <img src="vendor/core/plugins/vig-reactions/icon/angry-a.gif" alt="angry" height="80px">
        </div>
    </div>
</div>


@php

    Theme::asset()
             ->add('vig-reaction', 'vendor/core/plugins/vig-reactions/vig-reaction.0610.css');
    Theme::asset()
            ->container('footer')
            ->add('vig-reaction', 'vendor/core/plugins/vig-reactions/vig-reaction.0610.js');
@endphp
