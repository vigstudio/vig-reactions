

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="wrap">
    <div class="rect">
        <div class="row">
            <div class="col-xs-12">
                <input type="hidden" id="reaction_id" value="{{ $content[0] }}">
                <input type="hidden" id="reaction_type" value="{{ $content[1] }}">
                <div class="col-xs-2" style="text-align:center">
                    <img data-type="like" class="circle vigreaction" src="vendor/core/plugins/vig-reactions/icon/like-a.gif" alt="like" title="Like">
                    <span class="badge badge-danger" id="vig-reaction-like" data-count="{{ $reations->where('type', 'like')->count() }}">
                        {{ $reations->where('type', 'like')->count() }}
                    </span>
                </div>

                <div class="col-xs-2" style="text-align:center">
                    <img data-type="love" class="circle vigreaction" src="vendor/core/plugins/vig-reactions/icon/love-a.gif" alt="love" title="Love">
                    <span class="badge badge-danger" id="vig-reaction-love" data-count="{{ $reations->where('type', 'love')->count() }}">
                        {{ $reations->where('type', 'love')->count() }}
                    </span>
                </div>

                <div class="col-xs-2" style="text-align:center">
                    <img data-type="haha" class="circle vigreaction" src="vendor/core/plugins/vig-reactions/icon/haha-a.gif" alt="haha" title="Haha">
                    <span class="badge badge-danger" id="vig-reaction-haha" data-count="{{ $reations->where('type', 'haha')->count() }}">
                        {{ $reations->where('type', 'haha')->count() }}
                    </span>
                </div>

                <div class="col-xs-2" style="text-align:center">
                    <img data-type="wow" class="circle vigreaction" src="vendor/core/plugins/vig-reactions/icon/wow-a.gif" alt="wow" title="Wow">
                    <span class="badge badge-danger" id="vig-reaction-wow" data-count="{{ $reations->where('type', 'wow')->count() }}">
                        {{ $reations->where('type', 'wow')->count() }}
                    </span>
                </div>

                <div class="col-xs-2" style="text-align:center">
                    <img data-type="sad" class="circle vigreaction" src="vendor/core/plugins/vig-reactions/icon/sad-a.gif" alt="sad" title="Sad">
                    <span class="badge badge-danger" id="vig-reaction-sad" data-count="{{ $reations->where('type', 'sad')->count() }}">
                        {{ $reations->where('type', 'sad')->count() }}
                    </span>
                </div>

                <div class="col-xs-2" style="text-align:center">
                    <img data-type="angry" class="circle vigreaction" src="vendor/core/plugins/vig-reactions/icon/angry-a.gif" alt="angry" title="Angry">
                    <span class="badge badge-danger" id="vig-reaction-angry" data-count="{{ $reations->where('type', 'angry')->count() }}">
                        {{ $reations->where('type', 'angry')->count() }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>


@php

    Theme::asset()
             ->add('vig-reaction', 'vendor/core/plugins/vig-reactions/vig-reaction.css');
    Theme::asset()
             ->container('footer')
             ->add('tippy', 'https://unpkg.com/tippy.js@2.1.1/dist/tippy.all.min.js');
    Theme::asset()
            ->container('footer')
            ->add('vig-reaction', 'vendor/core/plugins/vig-reactions/vig-reaction.js');
@endphp
