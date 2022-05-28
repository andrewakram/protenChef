<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
    @if (trim($slot) === 'Laravel')
        <img src="{{url('default.jpg')}}" class="logo" alt="protein-chef">
    @else
        {{ $slot }}
    @endif
</a>
</td>
</tr>
