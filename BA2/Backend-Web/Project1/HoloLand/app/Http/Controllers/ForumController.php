<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Forum;
use App\Models\Privilege;
use App\Models\ThreadForm;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
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
        return $this->updateForumFromRequest($request, $forum);
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
            "title" => "required|string",
            "subtitle" => "required|string",
            "description" => "required|string",
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

        return $this->updateForumFromRequest($request, $forum);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * @param Request $request
     * @param Forum $forum
     * @return RedirectResponse
     */
    private function updateForumFromRequest(Request $request, Forum $forum): RedirectResponse
    {
        $forum->title = $request->get('title');

        $forum->subtitle = $request->get('subtitle');

        $forum->description = $request->get('description');

        if ($request->get('image-url') != null) {
            $forum->image_id = Asset::fromURL($request->get('image-url'))->id;
        } elseif ($request->get('image-file') != null) {
            $forum->image_id = Asset::fromFile($request->file('image-file'))->id;
        }
        $forum->save();

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

        $this->handleForm($request, $forum->id);


        return redirect()->route('forums.show', ['forum' => $forum->id]);
    }

    private function handleForm(Request $request, int $id) {
        $fieldCount = $request->get('field-counter');

        if ($fieldCount == null) {
            return;
        }

        if ($fieldCount < 1) {
            return;
        }

        $ids = [];

        for ($count = 0; $count < $fieldCount; $count++) {
            $fieldType = $request->get('field-type-' . $count);
            if ($fieldType == null) {
                continue;
            }

            $request->validate([
                "field-title-" . $count => "required|string|max:255",
                "field-desc-" . $count => "nullable|string|max:255",
                "field-placeholder-" . $count => "nullable|string|max:255",
            ]);

            $fieldTitle = $request->get('field-title-' . $count);
            $fieldDescription = $request->get('field-desc-' . $count);
            $fieldPlaceHolder = $request->get('field-placeholder-' . $count);

            $field = ThreadForm::where(['forum_id' => $id, 'field_count' => $count])->first();
            if ($field == null) {
                $field = new ThreadForm();
            }

            $field->field_count = $count;
            $field->forum_id = $id;
            $field->label = $fieldTitle;
            $field->description = $fieldDescription;
            $field->placeholder = $fieldPlaceHolder;
            $field->type = $fieldType;
            $field->save();

            $ids[] = $field->id;
        }

        ThreadForm::whereNotIn('id', $ids)->where(['forum_id' => $id])->delete();
    }
}
