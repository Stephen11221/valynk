@extends('layouts.account')

@section('title', 'Family Documents')
@section('body-class', 'account-reference family-documents-page')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="{{ asset('css/account-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/family-documents.css') }}">
@endpush

@section('header')
<header class="family-header">
    <div>
        <a class="family-brand" href="{{ route('home') }}"><img src="{{ asset('logo/logo.jpeg') }}" alt="VALYNK home"></a>
        <nav aria-label="Website navigation">
            @foreach (['home' => 'Home', 'about' => 'About', 'how-it-works' => 'How It Works', 'solutions' => 'Solutions', 'families' => 'For Families', 'providers' => 'For Providers', 'institutions' => 'For Institutions', 'pricing' => 'Pricing', 'contact' => 'Contact'] as $destination => $label)
                <a href="{{ route($destination) }}">{{ $label }}</a>
            @endforeach
        </nav>
        <details class="family-user-menu"><summary><span class="family-avatar">{{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}</span><span>Hello, {{ $user->name }}</span><i class="fa-solid fa-chevron-down" aria-hidden="true"></i></summary><div><a href="{{ route('account.profile.edit') }}">My profile</a><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Log out</button></form></div></details>
    </div>
</header>
@endsection

@section('content')
<div class="family-workspace">
    <aside class="family-sidebar" aria-label="Family dashboard">
        <h2>Family dashboard</h2>
        <nav aria-label="Family navigation">
            <a href="{{ route('dashboard') }}"><i class="fa-solid fa-table-cells-large" aria-hidden="true"></i>Overview</a>
            @foreach (['users' => 'My Children', 'bullseye' => 'Matches', 'calendar-days' => 'Appointments', 'message' => 'Messages', 'credit-card' => 'Payments'] as $icon => $label)
                <span class="family-nav-unavailable" aria-disabled="true" title="This section is not available yet"><i class="fa-solid fa-{{ $icon }}" aria-hidden="true"></i>{{ $label }}<small>Soon</small></span>
            @endforeach
            <a class="active" href="{{ route('account.family.documents') }}" aria-current="page"><i class="fa-regular fa-folder" aria-hidden="true"></i>Documents</a>
            <a href="{{ route('account.profile.edit') }}"><i class="fa-solid fa-gear" aria-hidden="true"></i>Settings</a>
        </nav>
        <div class="family-help"><span><i class="fa-solid fa-headset" aria-hidden="true"></i></span><div><strong>Need help?</strong><p>We’re here to help you every step of the way.</p><a href="{{ route('contact') }}">Contact support →</a></div></div>
    </aside>

    <section class="family-document-main" aria-labelledby="documents-title">
        <h1 id="documents-title">Documents</h1>
        <p class="family-subtitle">Store and manage your family’s important documents in one place.</p>
        @include('account.partials.status')
        @if ($errors->getBag('default')->any())
            <div class="family-alert" role="alert">{{ $errors->getBag('default')->first() }}</div>
        @endif
        <div class="family-toolbar">
            <form method="GET" action="{{ route('account.family.documents') }}" class="family-search" role="search">
                <label class="sr-only" for="document-search">Search documents or child names</label>
                <input id="document-search" name="q" placeholder="Search documents…" value="{{ $filters['q'] ?? '' }}" maxlength="100">
                @foreach (['folder', 'type', 'sort'] as $filter)
                    @if (!empty($filters[$filter]))<input type="hidden" name="{{ $filter }}" value="{{ $filters[$filter] }}">@endif
                @endforeach
                <button type="submit" aria-label="Search documents"><i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i></button>
            </form>
            <button class="family-button" type="button" data-dialog="filter-dialog"><i class="fa-solid fa-sliders" aria-hidden="true"></i> Filter</button>
            <button class="family-button" type="button" data-dialog="folder-dialog"><i class="fa-regular fa-folder" aria-hidden="true"></i> New folder</button>
            <button class="family-button primary" type="button" data-dialog="upload-dialog"><i class="fa-solid fa-arrow-up-from-bracket" aria-hidden="true"></i> Upload document</button>
        </div>

        <div class="family-section-title"><h2>My folders <span>({{ $folders->count() }})</span></h2><a href="{{ route('account.family.documents') }}">View all documents</a></div>
        <div class="family-folders">
            @foreach ($folders as $folder)
                <a class="family-folder {{ (int) ($filters['folder'] ?? 0) === $folder->id ? 'selected' : '' }}" href="{{ route('account.family.documents', ['folder' => $folder->id]) }}" @if ((int) ($filters['folder'] ?? 0) === $folder->id) aria-current="true" @endif><i class="fa-regular fa-folder" aria-hidden="true"></i><span><strong>{{ $folder->name }}</strong><small>{{ $folder->documents_count }} {{ Str::plural('file', $folder->documents_count) }}</small></span></a>
            @endforeach
            <button class="family-folder new-folder" type="button" data-dialog="folder-dialog"><i class="fa-solid fa-plus" aria-hidden="true"></i><strong>Create new folder</strong></button>
        </div>
        <div class="family-section-title document-list-title"><h2>{{ !empty($filters['q']) || !empty($filters['folder']) || !empty($filters['type']) ? 'Filtered documents' : 'All documents' }} <span>({{ $documents->total() }})</span></h2>
            <form method="GET" action="{{ route('account.family.documents') }}" class="family-sort">
                @foreach (['q', 'folder', 'type'] as $filter)
                    @if (!empty($filters[$filter]))<input type="hidden" name="{{ $filter }}" value="{{ $filters[$filter] }}">@endif
                @endforeach
                <label for="document-sort">Sort by:</label><select id="document-sort" name="sort"><option value="recent" @selected(($filters['sort'] ?? 'recent') === 'recent')>Recent</option><option value="oldest" @selected(($filters['sort'] ?? '') === 'oldest')>Oldest</option><option value="name" @selected(($filters['sort'] ?? '') === 'name')>Name</option><option value="size" @selected(($filters['sort'] ?? '') === 'size')>Largest</option></select><button type="submit" aria-label="Apply sort"><i class="fa-solid fa-arrow-down-wide-short" aria-hidden="true"></i></button>
            </form>
        </div>
        @if (!empty($filters['q']) || !empty($filters['folder']) || !empty($filters['type']))
            <p class="family-filter-summary">Filters active. <a href="{{ route('account.family.documents') }}">Clear filters</a></p>
        @endif
        <div class="family-table-scroll" tabindex="0" role="region" aria-label="Family documents table">
            <table class="family-documents-table">
                <thead><tr><th scope="col">Name</th><th scope="col">Child</th><th scope="col">Type</th><th scope="col">Uploaded</th><th scope="col">Size</th><th scope="col">Actions</th></tr></thead>
                <tbody>
                    @forelse ($documents as $document)
                        <tr>
                            <td><div class="family-file-name"><span class="family-file-icon {{ $document->extension }}"><i class="fa-regular fa-file-{{ match ($document->extension) { 'pdf' => 'pdf', 'docx' => 'word', 'xlsx' => 'excel', default => 'image' } }}" aria-hidden="true"></i></span><span><strong>{{ $document->name }}</strong><small>{{ $document->folder?->name ?? 'Unfiled' }}</small></span></div></td>
                            <td>{{ $document->child_name ?: '—' }}</td>
                            <td><span class="family-file-type {{ $document->extension }}">{{ strtoupper($document->extension) }}</span></td>
                            <td>{{ $document->created_at->format('d M Y') }}<small>by you</small></td>
                            <td class="family-file-size">{{ Number::fileSize($document->size, precision: 1) }}</td>
                            <td><div class="family-file-actions"><a class="family-icon-button" href="{{ route('account.family.documents.download', $document) }}" aria-label="Download {{ $document->name }}"><i class="fa-solid fa-download" aria-hidden="true"></i></a><form method="POST" action="{{ route('account.family.documents.destroy', $document) }}" data-delete-document="{{ $document->name }}">@csrf @method('DELETE')<button class="family-icon-button delete" type="submit" aria-label="Delete {{ $document->name }}"><i class="fa-regular fa-trash-can" aria-hidden="true"></i></button></form></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="6"><div class="family-empty"><i class="fa-regular fa-folder-open" aria-hidden="true"></i><h3>{{ $fileCount ? 'No matching documents' : 'A home for your family’s documents' }}</h3><p>{{ $fileCount ? 'Try a different search or clear your filters.' : 'Upload an assessment, report, invoice or certificate to get started.' }}</p>@if (!$fileCount)<button class="family-button primary" type="button" data-dialog="upload-dialog">Upload your first document</button>@endif</div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="family-pagination">{{ $documents->links() }}</div>
    </section>

    <aside class="family-insights" aria-label="Document tools">
        <section class="family-insight-card" id="storage-overview">
            <h2>Storage overview</h2>
            <div class="family-storage-ring" style="--document-share: {{ $usedBytes > 0 ? round($documentBytes / $usedBytes * 100, 2) : 0 }}%; --ring-base: {{ $usedBytes > 0 ? '#ac7ce5' : '#e8e8ef' }}"><div><strong>{{ Number::fileSize($usedBytes, precision: 1) }}</strong><span>{{ $fileCount }} {{ Str::plural('file', $fileCount) }} stored</span></div></div>
            <dl class="family-storage-legend"><div><dt><span class="storage-dot documents"></span>Documents</dt><dd>{{ Number::fileSize($documentBytes, precision: 1) }}</dd></div><div><dt><span class="storage-dot images"></span>Images</dt><dd>{{ Number::fileSize($imageBytes, precision: 1) }}</dd></div></dl>
            <p class="family-storage-note">PDF, Word, Excel, JPG and PNG files. Up to {{ Number::fileSize($uploadLimitKb * 1024) }} per upload.</p>
        </section>
        <section class="family-insight-card family-quick-actions"><h2>Quick actions</h2><button type="button" data-dialog="upload-dialog"><i class="fa-solid fa-arrow-up-from-bracket" aria-hidden="true"></i>Upload document<span aria-hidden="true">→</span></button><button type="button" data-dialog="folder-dialog"><i class="fa-regular fa-folder" aria-hidden="true"></i>Create new folder<span aria-hidden="true">→</span></button><a href="{{ route('contact') }}"><i class="fa-regular fa-circle-question" aria-hidden="true"></i>Get document help<span aria-hidden="true">→</span></a><a href="{{ route('account.profile.edit') }}"><i class="fa-solid fa-gear" aria-hidden="true"></i>Account settings<span aria-hidden="true">→</span></a></section>
        <section class="family-security"><i class="fa-solid fa-shield-halved" aria-hidden="true"></i><div><h2>Your documents are private.</h2><p>Only your signed-in family account can access these files.</p><button type="button" data-dialog="security-dialog">How access works <span aria-hidden="true">→</span></button></div></section>
    </aside>
</div>

<dialog id="upload-dialog" class="family-dialog" @if ($errors->getBag('upload')->any()) data-reopen @endif aria-labelledby="upload-title">
    <div class="family-dialog-heading"><h2 id="upload-title">Upload document</h2><button type="button" data-close-dialog aria-label="Close upload dialog">×</button></div>
    <p>Add a document to your private family library.</p>
    @if ($errors->getBag('upload')->any())<div class="family-alert" role="alert">{{ $errors->getBag('upload')->first() }}</div>@endif
    <form method="POST" action="{{ route('account.family.documents.store') }}" enctype="multipart/form-data">@csrf
        <label for="upload-file">Document <span>(required)</span></label><input id="upload-file" data-max-bytes="{{ $uploadLimitKb * 1024 }}" type="file" name="document" accept=".pdf,.docx,.xlsx,.jpg,.jpeg,.png" required aria-describedby="upload-hint"><p id="upload-hint">PDF, DOCX, XLSX, JPG or PNG · Maximum {{ Number::fileSize($uploadLimitKb * 1024) }}</p>
        <label for="upload-child">Child’s name <span>(optional)</span></label><input id="upload-child" name="child_name" maxlength="100" value="{{ old('child_name') }}" placeholder="Who is this document for?">
        <label for="upload-folder">Folder</label><select id="upload-folder" name="family_folder_id"><option value="">Unfiled</option>@foreach ($folders as $folder)<option value="{{ $folder->id }}" @selected((string) old('family_folder_id', $filters['folder'] ?? '') === (string) $folder->id)>{{ $folder->name }}</option>@endforeach</select>
        <button class="family-button primary" type="submit">Upload document</button>
    </form>
</dialog>
<dialog id="folder-dialog" class="family-dialog" @if ($errors->getBag('folder')->any()) data-reopen @endif aria-labelledby="folder-title">
    <div class="family-dialog-heading"><h2 id="folder-title">Create new folder</h2><button type="button" data-close-dialog aria-label="Close new folder dialog">×</button></div>
    <p>Keep your assessments, reports and certificates organised.</p>
    @if ($errors->getBag('folder')->any())<div class="family-alert" role="alert">{{ $errors->getBag('folder')->first() }}</div>@endif
    <form method="POST" action="{{ route('account.family.folders.store') }}">@csrf<label for="folder-name">Folder name</label><input id="folder-name" name="folder_name" value="{{ old('folder_name') }}" maxlength="100" placeholder="e.g. Assessments" required><button class="family-button primary" type="submit">Create folder</button></form>
</dialog>
<dialog id="filter-dialog" class="family-dialog" aria-labelledby="filter-title">
    <div class="family-dialog-heading"><h2 id="filter-title">Filter documents</h2><button type="button" data-close-dialog aria-label="Close filters">×</button></div>
    <form method="GET" action="{{ route('account.family.documents') }}">
        @foreach (['q', 'folder', 'sort'] as $filter)@if (!empty($filters[$filter]))<input type="hidden" name="{{ $filter }}" value="{{ $filters[$filter] }}">@endif @endforeach
        <label for="document-type">File type</label><select id="document-type" name="type"><option value="">All file types</option>@foreach (['pdf', 'docx', 'xlsx', 'jpg', 'png'] as $type)<option value="{{ $type }}" @selected(($filters['type'] ?? '') === $type)>{{ strtoupper($type) }}</option>@endforeach</select><button class="family-button primary" type="submit">Apply filter</button>
    </form>
</dialog>
<dialog id="security-dialog" class="family-dialog" aria-labelledby="security-title"><div class="family-dialog-heading"><h2 id="security-title">Private family storage</h2><button type="button" data-close-dialog aria-label="Close storage information">×</button></div><p>Files are stored outside the public website directory. Each download checks that you are signed in to the family account that uploaded it.</p><p>Sharing with providers or other accounts is not enabled. You can download or delete your files from the document list.</p></dialog>
<script src="{{ asset('js/family-documents.js') }}" defer></script>
@endsection

@section('footer')
    @include('account.partials.footer')
@endsection
