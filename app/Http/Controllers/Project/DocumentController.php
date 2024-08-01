<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Project;
use App\Service\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($project_id)
    {
        Gate::authorize('viewAny', [Document::class, $project_id]);
        $project = Project::find($project_id);
        $documents = Document::where('project_id', $project_id)->with('user')->get();
        return inertia('User/Project/Document/Index')->with([
            'project' => $project,
            'documents' => $documents,
            'can' => [
                'create_document' => Auth::user()->can('create', [Document::class, $project_id]),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($project_id)
    {
        Gate::authorize('create', [Document::class, $project_id]);
        $project = Project::find($project_id);
        return inertia('User/Project/Document/Create')->with([
            'project' => $project,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $project_id)
    {
        Gate::authorize('create', [Document::class, $project_id]);

        $validated = $request->validate([
            'name' => 'required',
            'file' => 'required|max:20000',
            'description' => 'nullable',
        ]);

        $document = new Document($validated);
        $document->user_id = Auth::id();
        $document->project_id = $project_id;
        if ($request->hasFile('file')) {
            $file_name_to_save = FileUploadService::upload_document($request->file('file'));
            $document->file = $file_name_to_save;
        }
        $document->save();

        return redirect(route('user.projects.documents.index', $project_id))->with('success', 'Document added successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $project_id, string $document_id)
    {
        $document = Document::findOrFail($document_id);
        Gate::authorize('delete', $document);

        $file_url = $document->file;
        $document->delete();
        Storage::delete('public/project/document/file/' . $file_url);
        return redirect(route('user.projects.documents.index', $project_id))->with('success', 'Document deleted successfully');
    }

    public function download(string $project_id, string $document_id)
    {
        $document = Document::findOrFail($document_id);
        $path = '/public/project/document/file/' . $document->file;
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $name = $document->name . '.' . $extension;
        return response()->download(Storage::path($path), $name);
    }
}
