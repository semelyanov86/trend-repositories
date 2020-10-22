<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCommitRequest;
use App\Http\Requests\StoreCommitRequest;
use App\Http\Requests\UpdateCommitRequest;
use App\Models\Commit;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CommitController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('commit_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $commits = Commit::all();

        return view('admin.commits.index', compact('commits'));
    }

    public function create()
    {
        abort_if(Gate::denies('commit_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.commits.create');
    }

    public function store(StoreCommitRequest $request)
    {
        $commit = Commit::create($request->all());

        return redirect()->route('admin.commits.index');
    }

    public function edit(Commit $commit)
    {
        abort_if(Gate::denies('commit_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.commits.edit', compact('commit'));
    }

    public function update(UpdateCommitRequest $request, Commit $commit)
    {
        $commit->update($request->all());

        return redirect()->route('admin.commits.index');
    }

    public function show(Commit $commit)
    {
        abort_if(Gate::denies('commit_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.commits.show', compact('commit'));
    }

    public function destroy(Commit $commit)
    {
        abort_if(Gate::denies('commit_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $commit->delete();

        return back();
    }

    public function massDestroy(MassDestroyCommitRequest $request)
    {
        Commit::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
