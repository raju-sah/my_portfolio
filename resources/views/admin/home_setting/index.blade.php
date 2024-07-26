@extends('layouts.master')

@section('content')

    <div class="container-xxl">

        <x-breadcrumb model="Home Settings"></x-breadcrumb>

        <div class="card">

            <div class="card-body">

                <div class="d-flex justify-content-end">
                    <a href="{{route('admin.home-settings.create')}}" class="btn btn-sm btn-dark mb-2"><i class='bx bx-xs bx-plus'> </i>Create</a>
                </div>

                <div class="table-responsive no-wrap">
                    <table class="table" id="datatable">

                        <x-table.header :headers="['title','logo','status', 'Actions']"/>

                        <tbody id="tablecontents">
                        @forelse ($home_settings as $home_setting)
                            <tr>
                                <td>{{$loop->iteration}}</td>

                                <x-table.td>{{$home_setting->title}}</x-table.td>

                                <x-table.table_image name="{{$home_setting->logo }}" url="{{$home_setting->image_path }}"/>

                                <x-table.switch :model="$home_setting"/>

                                <td style="width:150px">
                                    <div class="actions d-flex">
                                        <x-table.view_btn route-view="{{route('admin.home-settings.show', ':id')}}" id="{{$home_setting->id}}"
                                                          model="DestinationCategory" name="home_setting"/>

                                        <x-table.edit_btn route-edit="{{route('admin.home-settings.edit', $home_setting->id) }}"/>

                                        <x-table.delete_btn route-destroy="{{route('admin.home-settings.destroy', $home_setting->id ) }}"/>
                                    </div>
                                </td>
                            </tr>

                            <x-table.show_modal id="{{$home_setting->id}}" model="DestinationCategory"/>

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
    @include('_helpers.modal_script',['name' => 'home_setting', 'route' => route('admin.home-settings.show', ':id')])
    @include('_helpers.datatable')
    @include('_helpers.status_change', ['url' => url('admin/status-change-home_setting')])
    @include('_helpers.swal_delete')
@endpush
