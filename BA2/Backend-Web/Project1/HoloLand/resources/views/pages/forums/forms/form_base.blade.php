<link rel="stylesheet" href="{{ asset("css/shared/forms.css") }}">
<link rel="stylesheet" href="{{ asset("css/pages/forums/forms/forum.css") }}">

<div id="form-container">

    <input name="field-counter" id="field-counter" type="number" value="{{ sizeof($fields) }}" hidden="hidden">

    <div class="form-buttons">
        <label class="form-btn dropdown-button" onclick="addField('text', 'Text')">Add Text</label>
        <label class="form-btn dropdown-button" onclick="addField('big-text', 'Big Text')">Add Big Text</label>
        <label class="form-btn dropdown-button" onclick="addField('bool', 'Yes/No')">Add Yes/No</label>
    </div>
</div>

<script>
    const formContainer = document.getElementById('form-container');
    const fieldCounter = document.getElementById('field-counter');
    let fieldCount = {{ sizeof($fields) }};
    function addField(type, name) {
        addFilledField(type, name, "", "", "");
    }

    function addFilledField(type, name, title, desc, place) {
        const field = document.createElement('div');
        field.id = `field-${fieldCount}`
        field.classList.add('form-field');
        field.innerHTML = `
            <div class="flex-row" style="justify-content: space-between">
                <h2>${name} Field</h2>
                <span onclick="deleteField('field-${fieldCount}')" class="hover-cursor">🗑️</span>
            </div>

            <input type="hidden" name="field-type-${fieldCount}" value="${type}">

            <label for="${type}-field-title-${fieldCount}">Field name</label><br>
            <input type="text" name="field-title-${fieldCount}" id="${type}-field-title-${fieldCount}" value="${title}"><br>

            <label for="${type}-field-desc-${fieldCount}">Field description</label><br>
            <input type="text" name="field-desc-${fieldCount}" id="${type}-field-desc-${fieldCount}" value="${desc}"><br>

            <label for="${type}-field-placeholder-${fieldCount}">Field placeholder</label><br>
            <input type="text" name="field-placeholder-${fieldCount}" id="${type}-field-placeholder-${fieldCount}" value="${place}"><br>
        `;
        formContainer.appendChild(field);
        fieldCount++;
        fieldCounter.value = fieldCount;
    }

    function deleteField(id) {
        const field = document.getElementById(id);
        field.remove();
    }

    @foreach($fields as $field)
        @switch($field->type)
            @case("big-text")
                addFilledField("big-text", "Big Text", "{{ $field->label }}", "{{ $field->description }}", "{{ $field->placeholder }}");
            @break
            @case('text')
                addFilledField("text", "Text", "{{ $field->label }}", "{{ $field->description }}", "{{ $field->placeholder }}");
            @break
            @case('bool')
                addFilledField("bool", "Yes/No", "{{ $field->label }}", "{{ $field->description }}", "{{ $field->placeholder }}");
            @break
        @endswitch
    @endforeach
</script>
