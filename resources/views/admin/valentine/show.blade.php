@extends('layouts.master')
@section('title', 'Valentine Submission Details')
@section('content')
    <div class="container-xxl">

        <x-breadcrumb model="Valentine"></x-breadcrumb>

        <div class="card">
        
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $dayConfig['emoji'] ?? '❤️' }} {{ $dayConfig['name'] ?? 'Valentine' }} Submission</h5>
                <a href="{{ route('admin.valentines.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bx bx-arrow-back"></i> Back
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="30%">UUID</th>
                                <td><code>{{ $submission->uuid }}</code></td>
                            </tr>
                            <tr>
                                <th>Sender Name</th>
                                <td>{{ $submission->sender_name }}</td>
                            </tr>
                            <tr>
                                <th>Day Type</th>
                                <td>{{ $dayConfig['emoji'] ?? '' }} {{ $dayConfig['name'] ?? $submission->day_type }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if($submission->status === 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($submission->status === 'accepted')
                                        <span class="badge bg-success">Accepted</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Open Count</th>
                                <td>{{ $submission->open_count }}</td>
                            </tr>
                            <tr>
                                <th>Likes Count</th>
                                <td>{{ $submission->likes_count }}</td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td>{{ $submission->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                            @if($submission->accepted_at)
                            <tr>
                                <th>Accepted At</th>
                                <td>{{ $submission->accepted_at->format('M d, Y H:i') }}</td>
                            </tr>
                            @endif
                            @if($submission->rejected_at)
                            <tr>
                                <th>Rejected At</th>
                                <td>{{ $submission->rejected_at->format('M d, Y H:i') }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-header">
                                <h6 class="mb-0">💌 Message</h6>
                            </div>
                            <div class="card-body">
                                <p style="font-style: italic;">{{ $submission->message }}</p>
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-header">
                                <h6 class="mb-0">🔗 Share Link</h6>
                            </div>
                            <div class="card-body">
                                <div class="input-group">
                                    <input type="text" class="form-control" value="{{ $submission->share_url }}" readonly id="shareUrl">
                                    <button class="btn btn-primary" onclick="copyUrl()">Copy</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function copyUrl() {
        document.getElementById('shareUrl').select();
        document.execCommand('copy');
        alert('Link copied!');
    }
    </script>
@endsection
