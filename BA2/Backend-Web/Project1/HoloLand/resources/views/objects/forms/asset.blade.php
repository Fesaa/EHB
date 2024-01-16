<label>{{ $label }}</label><br>
<div class="flex-row">
    <input type="radio" name="{{ $type . "-type" }}" value="URL" id="{{ $type . "-upload-radio-url" }}" checked>
    <label for="{{ $type . "-upload-radio-url" }}">URL</label>
    <input type="radio" name="{{ $type . "-type" }}" value="FILE" id="{{ $type . "-upload-radio-file" }}">
    <label for="{{ $type . "-upload-radio-file" }}">File</label><br>
</div>
<br>

<input type="text" name="{{ $type . "-url" }}" id="{{ $type . "-upload-url" }}">
<input type="file" name="{{ $type . "-file" }}" id="{{ $type . "-upload-file" }}" style="display: none;"><br>

<script>
    const {{ $type }}UploadRadioURL = document.getElementById("{{ $type . "-upload-radio-url" }}");
    const {{ $type }}UploadRadioFile = document.getElementById("{{ $type . "-upload-radio-file" }}");

    {{ $type }}UploadRadioURL.addEventListener("click", function () {
        document.getElementById("{{ $type . "-upload-url" }}").style.display = "block";
        document.getElementById("{{ $type . "-upload-file" }}").style.display = "none";
    });
    {{ $type }}UploadRadioFile.addEventListener("click", function () {
        document.getElementById("{{ $type . "-upload-url" }}").style.display = "none";
        document.getElementById("{{ $type . "-upload-file" }}").style.display = "block";
    });
</script>
