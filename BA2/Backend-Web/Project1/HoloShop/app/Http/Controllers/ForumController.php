<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Forum;
use App\Models\Privilege;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ForumController extends Controller
{
    public function index() {

        $forums = Forum::getVisibleForums(User::AuthUser());

        return view('pages.forums.index', [
            'forums' => $forums,
        ]);
    }

    public function forum(int $id) {
        $forum = Forum::getForum($id);
        if ($forum == null) {
            return redirect()->route('forum.index');
        }

        if (!$forum->canSee(User::AuthUser())) {
            return redirect()->route('forum.index');
        }

        return view('pages.forums.forum_page', [
            'forum' => $forum,
        ]);
    }

    public function thread(int $id) {
        $thread = Thread::getThread($id);
        if ($thread == null) {
            return redirect()->route('forum.index');
        }

        if (!$thread->canSee(User::AuthUser())) {
            return redirect()->route('forum.index');
        }

        return view('pages.forums.thread_page', [
            'thread' => $thread,
        ]);
    }

    public function edit(int $id)
    {
        $forum = Forum::getForum($id);
        if ($forum == null) {
            return redirect()->route('forum.index');
        }

        if (!$forum->canSee(User::AuthUser())) {
            return redirect()->route('forum.index');
        }

        if (!$forum->canEdit(User::AuthUser())) {
            return redirect()->route('forum.index');
        }

        return view('pages.forums.forms.forum', [
            'forum' => $forum,
        ]);
    }

    public function updateForum(int $id) {

        validator(request()->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image-url' =>  'nullable|url',
            'image-file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ])->validate();


        $forum = Forum::getForum($id);
        if ($forum == null) {
            $forum = new Forum();
        }

        if (!$forum->canSee(User::AuthUser())) {
            return redirect()->route('forum.index');
        }

        if (!$forum->canEdit(User::AuthUser())) {
            return redirect()->route('forum.index');
        }

        $title = request()->get('title');
        $subtitle = request()->get('subtitle');
        $description = request()->get('description');
        $image_url = request()->get('image-url');
        $image_file = request()->file('image-file');

        $this->update($forum, $title, $subtitle , $description, $image_url, $image_file);

        return redirect()->route('forum.page', ['id' => $forum->id]);
    }

    private function update(Forum $forum, string|null $title, string|null $subtitle , string|null $description, string|null $imageUrl,  UploadedFile|null $imageFile)  {

        if ($title != null) {
            $forum->title = $title;
        }

        if ($subtitle != null) {
            $forum->subtitle = $subtitle;
        }

        if ($description != null) {
            $forum->description = $description;
        }

        if ($imageUrl != null) {
            $forum->image_id = Asset::fromURL($imageUrl)->id;
        } else if ($imageFile != null) {
            $forum->image_id = Asset::fromData($imageFile)->id;
        }

        $forum->locks()->detach();
        $locks = Privilege::getAllForumLocks();
        foreach ($locks as $lock) {
            if (request()->has($lock->name)) {
                $forum->locks()->attach($lock->id);
            }
        }

        $forum->cloaks()->detach();
        $cloaks = Privilege::getAllForumCloaks();
        foreach ($cloaks as $cloak) {
            if (request()->has($cloak->name)) {
                $forum->cloaks()->attach($cloak->id);
            }
        }

        $forum->save();
    }
}
