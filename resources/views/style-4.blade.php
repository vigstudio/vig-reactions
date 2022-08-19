<meta name="csrf-token" content="{{ csrf_token() }}">

@php
    $data = json_decode($content);
    $array_reation = ['like', 'love', 'haha', 'wow', 'sad', 'angry'];
@endphp

<div class="c-reaction_bar" style="padding-top:30px" id="vig-reaction"
                                                        data-total="0"
                                                        data-id="{{ $data->reference_id }}"
                                                        data-type="{{ $data->reference_type }}">

    <div class="intercom-emoji-picker-group" id="emoji-picker">
        <span class="intercom-emoji-picker-emoji" title="like">👍</span>
        <span class="intercom-emoji-picker-emoji" title="love">❤️</span>
        <span class="intercom-emoji-picker-emoji" title="haha">😂</span>
        <span class="intercom-emoji-picker-emoji" title="wow">😮</span>
        <span class="intercom-emoji-picker-emoji" title="sad">😭</span>
        <span class="intercom-emoji-picker-emoji" title="angry">😡</span>
    </div>


    <button class="c-button-unstyled c-reaction_add c-reaction_add--feature_new_reactions" type="button" id="emoji-picker">
        <div class="c-reaction_add__container">
            <i class="c-icon c-reaction_add__icon c-reaction_add__icon--bg c-icon--small-reaction-bg"></i>
            <i class="c-icon c-reaction_add__icon c-reaction_add__icon--fg c-icon--small-reaction"></i>
        </div>
    </button>

    <span id="add-reaction-span"></span>

</div>


@php
    Theme::asset()
                ->add('vig-reaction', 'vendor/core/plugins/vig-reactions/style-4/style.css', [], [], '1.0.0');
    Theme::asset()
            ->container('footer')
            ->add('popperjs', 'https://unpkg.com/@popperjs/core@2', [], [], '1.0.0')
            ->add('vig-reaction', 'vendor/core/plugins/vig-reactions/style-4/scripts.js', [], [], '1.0.0');

@endphp
