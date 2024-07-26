@extends('layouts.master')

@section('content')

<div class="container-xxl">

    <x-breadcrumb model="All Notifications"></x-breadcrumb>

    <div class="card">

        <div class="card-body">

            <div class="table-responsive no-wrap">
                <table class="table" id="datatable">

                    <x-table.header :headers="['name', 'type', 'view', 'created at', 'read at']" />

                    <tbody id="tablecontents">
                        @forelse ($notifications as $notification)
                        <tr>
                            <td>{{$loop->iteration}}</td>

                            @if ($notification->type === 'App\Notifications\ContactedNotification')
                            <x-table.td>{{ $notification->data['contact']['id'] }}</x-table.td>
                            <x-table.td>{{ 'contact notification' }}</x-table.td>
                            <x-table.td>
                                <a class="mark-as-read" data-notification-id="{{ $notification->id }}" data-redirect-url="{{ route('admin.contacts.show-notification', $notification->data['contact']['id']) }}" href="#">View Notification
                                </a>
                            </x-table.td>
                            @endif

                            @if ($notification->type === 'App\Notifications\ReviewNotification')
                            <x-table.td>{{ $notification->data['review']['id'] }}</x-table.td>
                            <x-table.td>{{ 'review notification' }}</x-table.td>
                            <x-table.td>
                                <a class="mark-as-read" data-notification-id="{{ $notification->id }}" data-redirect-url="{{ route('admin.reviews.show-notification', $notification->data['review']['id']) }}" href="#">View Notification
                                </a>
                            </x-table.td>
                            @endif

                            <x-table.td>{{ $notification->created_at->format('Y-m-d') }}</x-table.td>
                            <x-table.td>{{ $notification->read_at ? $notification->read_at->format('Y-m-d') : 'Not read' }}</x-table.td>
                        </tr>

                        @empty
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('custom_js')
@include('_helpers.datatable')
@endpush