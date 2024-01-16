<label for="{{ $type }}"> {{$label}} </label>
<p style="font-size: small; text-align: left">
    BBCode is available for formatting, use square brackets with specific tags like [b] for bold text or [url] for hyperlinks. For example, [b]This is bold[/b] and [url=https://www.example.com]Visit here[/url]. If you want to quote text, use [quote]. For further details, check this <a target="_blank" href="https://en.wikipedia.org/wiki/BBCode">page</a>.
</p>
<textarea id="{{ $type }}" name="{{ $type }}" cols="100" rows="15">{{ $value }}</textarea><br>
