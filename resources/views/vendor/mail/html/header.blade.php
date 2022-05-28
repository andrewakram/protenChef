<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
    @if (trim($slot) === 'Laravel')
        <img src="{{ @url('/') }}/default.png" class="logo" alt="protein-chef">
    @else
        {{ $slot }}
    @endif
</a>
</td>
</tr>
