<link rel="stylesheet" href="{{ asset("css/shared/forms.css") }}">
<link rel="stylesheet" href="{{ asset("css/pages/forums/forms/forum.css") }}">

<div class="styled-form-container">
    <form class="styled-form label-left"
          method="post"
          action="{{ $route }}">
        @csrf
        @method($method)

        <input type="number" name="forum_id" value="{{ $forum_id }}" hidden>

        <label for="title">Title</label><br>
        <input type="text" name="title" id="title" value="{{ $title }}"><br>

        @include('objects.forms.bbcode', ["label" => "Content", "type"=> "content", "value" => $content])

        @if(\App\Models\User::AuthUser()->hasPrivilegeByString("FEATURED_EDIT"))
            <label for="featured">Featured?</label>
            <input type="checkbox" id="featured" name="featured" @if($thread->featured)checked="checked"@endif>
            @include('objects.forms.asset', ["label" => "Banner image", "type"=> "image"])
        @endif

        <div class="flex-row">
            @if($cloaks)
                <div id="forum-cloaks" class="dropdown-holder">
                    <label id="forum-dropdown-cloaks-btn" class="form-btn dropdown-button" onclick="cloaks()">Assign cloaks</label>
                    <div id="forum-dropdown-cloaks-content" class="hidden dropdown-content flex-column" style="margin-top: 1em">
                        @foreach(\App\Models\Privilege::getAllThreadCloaks() as $cloak)
                            <label><input type="checkbox" name="{{ $cloak->name }}" value="{{ $cloak->name }}"
                                          @if($thread != null && $thread->hasCloak($cloak->name))
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
                        @foreach(\App\Models\Privilege::getAllThreadLocks() as $lock)
                            <label><input type="checkbox" name="{{ $lock->name }}" value="{{ $lock->name }}"
                                          @if($thread != null && $thread->hasLock($lock->name))
                                              checked="checked"
                                    @endif>{{ $lock->name()}}</label>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <br><br><br>
        <input type="submit" value="Save" class="styled-form-confirm">
    </form>
</div>

<script>
    const cloaksButton = document.getElementById('forum-dropdown-cloaks-btn');
    const cloaksDropdownContent = document.getElementById('forum-dropdown-cloaks-content');

    const locksButton = document.getElementById('forum-dropdown-locks-btn');
    const locksDropdownContent = document.getElementById('forum-dropdown-locks-content');


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

</script>
