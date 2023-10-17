
<link href="{{ asset('css/pages/about.css') }}" rel="stylesheet">

@extends('layouts.master')

@section('main-content')

    <div class="float flex-column" id="about-me">

        <h1 style="flex: 1; text-align: center">Static About Page</h1>

        <p style="font-size: x-small">Only the content inside the master layout is static,
            as such some section of this page still require a connection to the database.</p>

        <h3>Resources</h3>

        <p>As requested, a list of any resources, to a reasonable point, used while working on the project.</p>

        <ul>
            <li>The official Laravel <a href="https://laravel.com/docs/10.x" target="_blank">documentation</a></li>
            <li>Various <a href="https://stackoverflow.com/" target="_blank">Stack Overflow</a> threads</li>
            <li>Some AI tools, for code completion and generation of content (threads, forums)
                <ul>
                    <li>OpenAI's <a href="https://chat.openai.com/" target="_blank">Chat GPT-3.5</a></li>
                    <li>GitHub's <a href="https://github.com/features/copilot" target="_blank">Copilot</a></li>
                </ul>
            </li>
            <li>The Mozilla web development <a href="https://developer.mozilla.org/en-US/" target="_blank">documentation</a></li>
        </ul>

        <h3>An overview of the <span class="canvas-header">Functional minimum requirements</span></h3>
        <ul style="margin-top: 0">
            <li class="canvas-requirement-box" id="login-system">
               <h4>Login System</h4>
               <p>
                   A user may log in, register, and logout with the button located at the right of the header bar.<br>
                   A user may have one, or several roles assigned to them by someone with the <span class="code-block">MEMBERS_EDIT_ROLES</span>
                   privilege. <br>
                   This privilege is, by default, only granted to the <span class="code-block">ADMIN</span> role.
                   Permission distribution may be changed through the staff panel.
               </p>
            </li>
            <li class="canvas-requirement-box" id="profile-age">
                <h4>Profile page</h4>
                <p>
                    Each user has a profile page generated for them, which can be accessed via the left sidebar. <br>
                    On creation, a default avatar and banner is assigned to the profile. These can be changed, along with their pronouns, an about me, and their birthday by the user. <br>
                    A user may change their title, if they have the <span class="code-block">TITLE_EDIT</span> privilege. <br>
                    A profile page can be edited by the user, and anyone with the <span class="code-block">MEMBERS_EDIT_PROFILE</span> privilege.<br>
                </p>
            </li>
            <li class="canvas-requirement-box" id="latest-news">
                <h4>Latest news</h4>
                <p>
                    The <a href="{{ route('forums.show', 1) }}" target="_blank">News</a> forum can be used to post news. Any of it's thread will be displayed on the
                    <a href="{{ route('home') }}" target="_blank">home</a> page. <br>
                    This forum is by default locked with the <span class="code-block">FORUM_LOCK_ADMIN</span> lock, but not cloaked. <br>
                    Each thread, not necessarily in the news forum, may be featured in the home page with a cover image. The
                    <a href="{{ route('threads.show', 1) }}" target="_blank">Opening Celebration</a> thread is so by default.
                </p>
            </li>
            <li class="canvas-requirement-box" id="faq-page">
                <h4>FAQ page</h4>
                <p>
                    The <a href="{{ route('forums.show', 4) }}" target="_blank">FAQ</a> forum can be used to post frequently asked questions.
                    Threads may be used to split up categories <br>
                    This forum is by default locked with the <span class="code-block">FORUM_LOCK_STAFF</span> lock, but not cloaked. <br>
                </p>
                <p class="important-note">
                    This differs slightly from the canvas requirement page, by taking categories as threads. Rather than each FAQ pair as a thread <br>
                    Categories edits, are thus thread title edits, and FAQ questions edits are thread content edits.
                </p>
            </li>
            <li class="canvas-requirement-box" id="contact-page">
                <h4>Contact Page</h4>
                <p>
                    To implement.
                </p>
            </li>
        </ul>

        <h3>An overview of the <span class="canvas-header">Technical requirements</span></h3>
        <ul>
            <li class="canvas-requirement-box" id="views">
                <h4>Views</h4>
                <p>
                    You are on the ✨ about page ✨ 😎 <br>
                    There are technically 4/5 layouts, depending on how you count them. There is a master layout, on which everything builds only containing the header, footer, and the sidebar <br>
                    This layout is used for most pages but, the staff panel, logs panel, and account settings has an intermediate layout Which builds on the master layout, but may remove the infobar (right sidebar).
                </p>
                <p class="important-note">
                    One could argue there is thus only one layout, but I'm counting the intermediate layout as a separate one, as it is extended from.
                </p>
                <p>
                    Partials, or objects, are used for the header, footer, and sidebar. And other things used across multiple pages, such as the different sizes profiles.
                </p>
            </li>
            <li class="canvas-requirement-box" id="routes">
                <h4>Routes</h4>
                <p>
                    The project used <span class="code-block">Route::resource</span> for user facing objects like forums, threads, posts, etc. <br>
                    And standard <span class="code-block">Route::get</span>, <span class="code-block">Route::post</span> for others. The admin routes are also
                    grouped behind a middleware to check if the user has the <span class="code-block">STAFF</span> role.
                </p>
            </li>
            <li class="canvas-requirement-box" id="controllers">
                <h4>Controllers</h4>
                <p>
                    See <span class="code-block">/app/Http/Controllers</span>.
                </p>
            </li>
            <li class="canvas-requirement-box" id="models">
                <h4>Models</h4>
                <p>
                    Eloquent models are used for all database objects. See <span class="code-block">/app/Models</span>. <br>
                    There are one-many relations between forums and threads, threads and posts, and users and posts. <br>
                    There are many-many relations between users and roles, roles and privileges. <br> <br>

                    The concept of them is pretty neath, and it works okey-ish, but php being weakly typed kinda does ruin it all... lol <br>
                    The fields being a list of strings, is so useless as well. It doesn't force <i>any</i> types from the model, only from the migration.
                    The function on a model are not all listed with the lsp, would be easier to just write raw sql and cast/load it to a proper class.
                    Gives you easier control as well. Sure, you might have to maintain a bit more stuff, and known joins, but you're in total control of it as well. <br>
                </p>
            </li>
            <li class="canvas-requirement-box" id="database">
                <h4>Database</h4>
                <p>
                    Migration files are cool, but again, the factories not being typed defeats their point and I might as well cat some <span class="code-block">.sql</span> files instead. <br>
                    There is a bunch of dummy data as well :)
                </p>
            </li>
            <li class="canvas-requirement-box" id="authentication">
                <h4>Authentication</h4>
                <p>
                    You can change your password, forgetting it still has to be implemented. <br>
                    This is probably the only useful thing about Laravel, having it all build in. Most of the framework just feels like syntax sugar, that gives me less control over what I do. <br>
                    Default account for admin is in the seeders.
                </p>
            </li>
            <li class="canvas-requirement-box" id="theming-styles">
                <h4>Theming/styles</h4>
                <p>
                    I think it looks pretty good, but I'm not a designer 😝 <br>
                </p>
            </li>
        </ul>


        <h3>Some extra info</h3>




        <p style="font-size: xx-small; text-align: center; flex: 1;">This could've been a cool thread but ✨ static ✨ </p>

    </div>

@endsection
