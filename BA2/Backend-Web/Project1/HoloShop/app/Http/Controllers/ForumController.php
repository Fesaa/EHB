<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Forum;
use App\Models\Privilege;
use App\Models\User;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forums = Forum::getVisibleForums(User::AuthUser());
        return view('pages.forums.index', [
            'forums' => $forums,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (User::AuthUser() == null) {
            return redirect()->route('forums.index');
        }
        if (!User::AuthUser()->hasPrivilegeByString('FORUM_CREATE')) {
            return redirect()->route('forums.index');
        }

        $id = Forum::max('id') + 1;
        return view('pages.forums.create', [
            "forum" => null,
            "id" => $id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (User::AuthUser() == null) {
            return redirect()->route('forums.index');
        }
        if (!User::AuthUser()->hasPrivilegeByString('FORUM_CREATE')) {
            return redirect()->route('forums.index');
        }

        $request->validate([
            "title" => "required|string|max:255",
            "subtitle" => "required|string|max:255",
            "description" => "required|string",
            'image-url' => "nullable|url",
            'image-file' => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
        ]);

        $forum = new Forum();
        $forum->title = $request->get('title');
        $forum->subtitle = $request->get('subtitle');
        $forum->description = $request->get('description');
        if ($request->get('image-url') != null) {
            $forum->image_id = Asset::fromURL($request->get('image-url'))->id;
        } elseif ($request->get('image-file') != null) {
            $forum->image_id = Asset::fromFile($request->file('image-file'))->id;
        }

        $locks = Privilege::getAllForumLocks();
        $cloaks = Privilege::getAllForumCloaks();
        foreach ($locks as $lock) {
            if ($request->has($lock->name)) {
                $forum->locks()->attach($lock->id);
            } else {
                $forum->locks()->detach($lock->id);
            }
        }

        foreach ($cloaks as $cloak) {
            if ($request->has($cloak->name)) {
                $forum->cloaks()->attach($cloak->id);
            } else {
                $forum->cloaks()->detach($cloak->id);
            }
        }

        $forum->save();

        return redirect()->route('forums.show', ['forum' => $forum->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $forum = Forum::getForum($id);
        if ($forum == null) {
            return redirect()->route('forums.index');
        }

        if (!$forum->canSee(User::AuthUser())) {
            return redirect()->route('forums.index');
        }

        return view('pages.forums.show', [
            'forum' => $forum,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (User::AuthUser() == null) {
            return redirect()->route('forums.index');
        }
        if (!User::AuthUser()->hasPrivilegeByString('FORUM_EDIT')) {
            return redirect()->route('forums.index');
        }

        $forum = Forum::getForum($id);

        if ($forum == null) {
            return redirect()->route('forums.index');
        }

        return view('pages.forums.edit', [
            "forum" => $forum,
            "id" => $forum->id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "title" => "nullable|string",
            "subtitle" => "nullable|string",
            "description" => "nullable|string",
            'image-url' => "nullable|url",
            'image-file' => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
        ]);

        $forum = Forum::getForum($id);
        if ($forum == null) {
            return redirect()->route('forums.index');
        }

        if (!$forum->canSee(User::AuthUser())) {
            return redirect()->route('forums.index');
        }

        if (!$forum->canEdit(User::AuthUser())) {
            return redirect()->route('forums.index');
        }

        if ($request->get('title') != null) {
            $forum->title = $request->get('title');
        }

        if ($request->get('subtitle') != null) {
            $forum->subtitle = $request->get('subtitle');
        }

        if ($request->get('description') != null) {
            $forum->description = $request->get('description');
        }

        if ($request->get('image-url') != null) {
            $forum->image_id = Asset::fromURL($request->get('image-url'))->id;
        } elseif ($request->get('image-file') != null) {
            $forum->image_id = Asset::fromFile($request->file('image-file'))->id;
        }

        $locks = Privilege::getAllForumLocks();
        $cloaks = Privilege::getAllForumCloaks();
        foreach ($locks as $lock) {
            if ($request->has($lock->name)) {
                $forum->locks()->attach($lock->id);
            } else {
                $forum->locks()->detach($lock->id);
            }
        }

        foreach ($cloaks as $cloak) {
            if ($request->has($cloak->name)) {
                $forum->cloaks()->attach($cloak->id);
            } else {
                $forum->cloaks()->detach($cloak->id);
            }
        }

        $forum->save();

        return redirect()->route('forums.show', ['forum' => $forum->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
