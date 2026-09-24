<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\FamilyDocument;
use App\Models\FamilyFolder;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

class FamilyDocumentController extends Controller
{
    public function index(Request $request): View
    {
        $user = $this->family($request);
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'folder' => ['nullable', 'integer', Rule::exists('family_folders', 'id')->where('user_id', $user->id)],
            'type' => ['nullable', Rule::in(['pdf', 'docx', 'xlsx', 'jpg', 'png'])],
            'sort' => ['nullable', Rule::in(['recent', 'oldest', 'name', 'size'])],
        ]);
        $folders = FamilyFolder::where('user_id', $user->id)->withCount('documents')->orderBy('name')->get();
        $query = FamilyDocument::where('user_id', $user->id)->with('folder');
        if (! empty($filters['q'])) {
            $query->where(function (Builder $query) use ($filters): void {
                $query->where('name', 'like', '%'.$filters['q'].'%')
                    ->orWhere('child_name', 'like', '%'.$filters['q'].'%');
            });
        }
        if (! empty($filters['folder'])) {
            $query->where('family_folder_id', $filters['folder']);
        }
        if (! empty($filters['type'])) {
            $query->where('extension', $filters['type']);
        }
        [$column, $direction] = match ($filters['sort'] ?? 'recent') {
            'oldest' => ['created_at', 'asc'],
            'name' => ['name', 'asc'],
            'size' => ['size', 'desc'],
            default => ['created_at', 'desc'],
        };
        $documents = $query->orderBy($column, $direction)->orderByDesc('id')->paginate(8)->withQueryString();
        $totals = FamilyDocument::where('user_id', $user->id)
            ->selectRaw('extension, SUM(size) as bytes, COUNT(*) as files')->groupBy('extension')->get();
        $usedBytes = (int) $totals->sum('bytes');
        $imageBytes = (int) $totals->whereIn('extension', ['jpg', 'png'])->sum('bytes');
        $documentBytes = $usedBytes - $imageBytes;
        $fileCount = (int) $totals->sum('files');
        $uploadLimitKb = $this->uploadLimitKb();

        return view('account.family-documents', compact('user', 'folders', 'documents', 'filters', 'usedBytes', 'imageBytes', 'documentBytes', 'fileCount', 'uploadLimitKb'));
    }

    public function storeFolder(Request $request): RedirectResponse
    {
        $user = $this->family($request);
        $data = $request->validateWithBag('folder', [
            'folder_name' => ['required', 'string', 'max:100', Rule::unique('family_folders', 'name')->where('user_id', $user->id)],
        ]);
        FamilyFolder::create(['user_id' => $user->id, 'name' => $data['folder_name']]);

        return redirect()->route('account.family.documents')->with('status', 'Folder created.');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $this->family($request);
        $data = $request->validateWithBag('upload', [
            'document' => ['required', 'file', 'mimes:pdf,docx,xlsx,jpg,jpeg,png', 'extensions:pdf,docx,xlsx,jpg,jpeg,png', 'max:'.$this->uploadLimitKb()],
            'child_name' => ['nullable', 'string', 'max:100'],
            'family_folder_id' => ['nullable', 'integer', Rule::exists('family_folders', 'id')->where('user_id', $user->id)],
        ]);
        $file = $request->file('document');
        $path = $file->store('family-documents/'.$user->id, 'local');
        if ($path === false) {
            return back()->withErrors(['document' => 'The file could not be saved. Please try again.'], 'upload')->withInput();
        }
        try {
            FamilyDocument::create([
                'user_id' => $user->id,
                'family_folder_id' => $data['family_folder_id'] ?? null,
                'name' => mb_substr($file->getClientOriginalName(), 0, 255),
                'child_name' => $data['child_name'] ?? null,
                'path' => $path,
                'extension' => strtolower($file->getClientOriginalExtension()) === 'jpeg' ? 'jpg' : strtolower($file->getClientOriginalExtension()),
                'size' => $file->getSize(),
            ]);
        } catch (Throwable $exception) {
            Storage::disk('local')->delete($path);
            throw $exception;
        }

        return redirect()->route('account.family.documents')->with('status', 'Document uploaded.');
    }

    public function download(Request $request, int $document): StreamedResponse
    {
        $user = $this->family($request);
        $file = FamilyDocument::where('user_id', $user->id)->findOrFail($document);
        abort_unless(Storage::disk('local')->exists($file->path), 404);

        return Storage::disk('local')->download($file->path, $file->name, [
            'Content-Type' => 'application/octet-stream',
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'private, no-store',
        ]);
    }

    public function destroy(Request $request, int $document): RedirectResponse
    {
        $user = $this->family($request);
        $file = FamilyDocument::where('user_id', $user->id)->findOrFail($document);
        if (! Storage::disk('local')->delete($file->path)) {
            return back()->withErrors(['document' => 'The file could not be deleted. Please try again.']);
        }
        $file->delete();

        return redirect()->route('account.family.documents')->with('status', 'Document deleted.');
    }

    private function uploadLimitKb(): int
    {
        $limits = [10240];
        foreach (['upload_max_filesize', 'post_max_size'] as $setting) {
            $bytes = ini_parse_quantity((string) ini_get($setting));
            if ($bytes > 0) {
                $limits[] = max(1, (int) floor($bytes / 1024) - ($setting === 'post_max_size' ? 64 : 0));
            }
        }

        return min($limits);
    }

    private function family(Request $request): User
    {
        $user = $request->user();
        abort_unless($user->account_type === 'Family' && ! $user->is_admin, 403);

        return $user;
    }
}
