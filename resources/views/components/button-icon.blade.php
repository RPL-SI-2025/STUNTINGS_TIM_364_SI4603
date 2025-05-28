@props(['icon', 'title' => '', 'onclick' => ''])
<button type="button" class="btn-icon-mini" title="{{ $title }}" onclick="{{ $onclick }}">
    <i class="fas fa-{{ $icon }}"></i>
</button>