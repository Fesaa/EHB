<link rel="stylesheet" href="{{ asset("css/shared/forms.css") }}">
<link rel="stylesheet" href="{{ asset("css/pages/forums/forms/forum.css") }}">

<div class="styled-form-container">
    <form class="styled-form label-left"
          method="post"
          action="{{ $route }}">
        @csrf
        @method($method)

        <label for="title">Title</label><br>
        <input type="text" name="title" id="title" value="{{ $title }}"><br>

        @include('objects.forms.bbcode', ["label" => "Subtitle", "type"=> "subtitle", "value" => $subtitle])
        @include('objects.forms.bbcode', ["label" => "Description", "type"=> "description", "value" => $description])
        @include('objects.forms.asset', ["label" => "Forum image", "type"=> "image"])
        <div class="flex-row" style="margin: 30px">
            @if($cloaks)
                <div id="forum-cloaks" class="dropdown-holder">
                    <label id="forum-dropdown-cloaks-btn" class="form-btn dropdown-button" onclick="cloaks()">Assign cloaks</label>
                    <div id="forum-dropdown-cloaks-content" class="hidden dropdown-content flex-column" style="margin-top: 1em">
                        @foreach(\App\Models\Privilege::getAllForumCloaks() as $cloak)
                            <label><input type="checkbox" name="{{ $cloak->name }}" value="{{ $cloak->name }}"
                                          @if($forum != null && $forum->hasCloak($cloak->name))
                                              checked="checked"
                                    @endif>{{ $cloak->name()}}</label>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($locks)
                <div id="forum-locks" class="dropdown-holder">
                    <label id="forum-dropdown-locks-btn" class="form-btn dropdown-button" onclick="locks()">Assign locks</label>
                    <div id="forum-dropdown-locks-content" class="hidden dropdown-content flex-column" style="margin-top: 1em">
                        @foreach(\App\Models\Privilege::getAllForumLocks() as $lock)
                            <label><input type="checkbox" name="{{ $lock->name }}" value="{{ $lock->name }}"
                                          @if($forum != null && $forum->hasLock($lock->name))
                                              checked="checked"
                                    @endif>{{ $lock->name()}}</label>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <div class="flex-row" style="flex: 1; justify-content: center;">
            <div class="flex-column" style="flex: 1;">
                <div class="flex-row" style="flex: 1; justify-content: center">
                    <label id="forum-dropdown-form-btn" class="form-btn dropdown-button" onclick="formFunc()">Make thread creation form</label>
                </div>
                <div id="forum-dropdown-form-content" class="hidden dropdown-content" style="padding: 20px; justify-content: center">
                    @include('pages.forums.forms.form_base', ["fields" => $fields])
                </div>
            </div>
        </div>
        <input type="submit" value="Save" class="styled-form-confirm" style="margin-top: 1em">
    </form>
</div>

<script>
    const cloaksButton = document.getElementById('forum-dropdown-cloaks-btn');
    const cloaksDropdownContent = document.getElementById('forum-dropdown-cloaks-content');

    const locksButton = document.getElementById('forum-dropdown-locks-btn');
    const locksDropdownContent = document.getElementById('forum-dropdown-locks-content');

    const formButton = document.getElementById('forum-dropdown-form-btn');
    const formDropdownContent = document.getElementById('forum-dropdown-form-content');


    function dropdownmixer(el) {
        if (el.style.display === 'none' || el.style.display === '') {
            // Show the dropdown with a gradual animation
            el.style.display = 'flex';
            setTimeout(() => {
                el.style.opacity = '1';
            }, 10);
        } else {
            // Hide the dropdown with a gradual animation
            el.style.opacity = '0';
            setTimeout(() => {
                el.style.display = 'none';
            }, 300); // Adjust the duration of the animation (in milliseconds) as needed
        }
    }

    function cloaks() {
        dropdownmixer(cloaksDropdownContent);
    }

    function locks() {
        dropdownmixer(locksDropdownContent);
    }

    function formFunc() {
        dropdownmixer(formDropdownContent);
    }

</script>
