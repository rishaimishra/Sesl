<button type="button" onclick="window.location='{{ $button['url']($item) ?? '#' }}'"
        class="item"
        data-toggle="tooltip" data-placement="top" title=""
        data-original-title="{{ $button['label'] }}">
    <i class="material-icons">{{ $button['icon'] ?? strtolower($button['label']) }}</i>

</button>
