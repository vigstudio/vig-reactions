<meta name="csrf-token" content="{{ csrf_token() }}">

<div class='reactions' id="vig-reaction"
     data-total="0"
     data-id="{{ $data->reference_id }}"
     data-type="{{ $data->reference_type }}">
    @foreach ($reactionTypes as $reaction)
        <a class='reaction vigreaction' href='javascript:;' data-type="{{ $reaction }}">
            <span class='inner'>
                <span class='emoji'><img src="vendor/core/plugins/vig-reactions/icon/{{ $reaction }}-a.gif" alt="{{ $reaction }}" height="30px"></span>
                <span class='count' id="vig-reaction-{{ $reaction }}" data-count="0">0</span>
            </span>
        </a>
    @endforeach
</div>

<script>
    window.VigReaction = {
        get: "{{ route('vig.reaction.get') }}",
        press: "{{ route('vig.reaction.press') }}",
    };
</script>

@php
    Theme::asset()->add('vig-reaction', 'vendor/core/plugins/vig-reactions/style-2/style.css', [], [], '1.0.1');
    Theme::asset()
        ->container('footer')
        ->add('vig-reaction', 'vendor/core/plugins/vig-reactions/style-2/scripts.js', [], [], '1.0.1');
@endphp
