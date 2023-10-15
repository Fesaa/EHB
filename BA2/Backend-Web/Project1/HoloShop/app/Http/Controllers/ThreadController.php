<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Privilege;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('home');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (User::AuthUser() == null) {
            return redirect()->route('home');
        }
        if (!User::AuthUser()->hasPrivilegeByString('THREAD_CREATE')) {
            return redirect()->route('home');
        }

        $id = Thread::max('id') + 1;
        return view('pages.threads.create', [
            "thread" => null,
            "id" => $id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (User::AuthUser() == null) {
            return redirect()->route('home');
        }

        $request->validate([
            "forum_id" => "required|integer|exists:forums,id",
            "title" => "required|string|max:255",
            "content" => "required|string",
            'image-url' => "nullable|url",
            'image-file' => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
        ]);

        $thread = new Thread();
        $thread->forum_id = $request->input('forum_id');
        $thread->title = $request->input('title');
        $thread->content = $request->input('content');
        $thread->user_id = User::AuthUser()->id;
        if ($request->get('image-url') != null) {
            $thread->image_id = Asset::fromURL($request->get('image-url'))->id;
        } elseif ($request->get('image-file') != null) {
            $thread->image_id = Asset::fromFile($request->file('image-file'))->id;
        }

        $locks = Privilege::getAllThreadLocks();
        $cloaks = Privilege::getAllThreadCloaks();
        foreach ($locks as $lock) {
            if ($request->has($lock->name)) {
                $thread->locks()->attach($lock->id);
            } else {
                $thread->locks()->detach($lock->id);
            }
        }

        foreach ($cloaks as $cloak) {
            if ($request->has($cloak->name)) {
                $thread->cloaks()->attach($cloak->id);
            } else {
                $thread->cloaks()->detach($cloak->id);
            }
        }

        $thread->save();

        return redirect()->route('threads.show', $thread->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $thread = Thread::getThread($id);
        if ($thread == null) {
            return redirect()->route('404');
        }

        if (!$thread->canSee(User::AuthUser())) {
            return redirect()->route('404');
        }

        return view('pages.threads.show', [
            'thread' => $thread,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (User::AuthUser() == null) {
            return redirect()->route('home');
        }

        $thread = Thread::getThread($id);

        if ($thread == null) {
            return redirect()->route('404');
        }

        if (!$thread->canEdit(User::AuthUser())) {
            return redirect()->route('home');
        }

        return view('pages.threads.edit', [
            "thread" => $thread,
            "id" => $thread->id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (User::AuthUser() == null) {
            return redirect()->route('home');
        }

        $request->validate([
            "forum_id" => "required|integer|exists:forums,id",
            "title" => "nullable|string|max:255",
            "content" => "nullable|string",
            'image-url' => "nullable|url",
            'image-file' => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
        ]);

        $thread = Thread::getThread($id);
        if ($thread == null) {
            return redirect()->route('404');
        }

        if (!$thread->canEdit(User::AuthUser())) {
            return redirect()->route('home');
        }

        if ($request->get('title') != null) {
            $thread->title = $request->input('title');
        }

        if ($request->get('content') != null) {
            $thread->content = $request->input('content');
        }

        if ($request->get('image-url') != null) {
            $thread->image_id = Asset::fromURL($request->get('image-url'))->id;
        } elseif ($request->get('image-file') != null) {
            $thread->image_id = Asset::fromFile($request->file('image-file'))->id;
        }

        $locks = Privilege::getAllThreadLocks();
        $cloaks = Privilege::getAllThreadCloaks();

        foreach ($locks as $lock) {
            if ($request->has($lock->name)) {
                $thread->locks()->attach($lock->id);
            } else {
                $thread->locks()->detach($lock->id);
            }
        }

        foreach ($cloaks as $cloak) {
            if ($request->has($cloak->name)) {
                $thread->cloaks()->attach($cloak->id);
            } else {
                $thread->cloaks()->detach($cloak->id);
            }
        }

        $thread->save();

        return redirect()->route('threads.show', $thread->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
