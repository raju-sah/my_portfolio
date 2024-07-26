@extends('layouts.master')
@section('title', 'Testimonial')
@section('content')

<div class="container-xxl">

     <x-breadcrumb model="Testimonial"></x-breadcrumb>

    <div class="card">

        <div class="card-body">

          <div class="d-flex justify-content-end">
            <a href="{{route('admin.testimonials.create')}}" class="btn btn-sm btn-dark mb-2"><i class='bx bx-xs bx-plus'> </i>Create</a>
          </div>

        <div class="table-responsive no-wrap">
          <table class="table" id="datatable">

           <x-table.header :headers="['name','email','position','status', 'Actions']" />

             <tbody id="tablecontents">
                @forelse ($testimonials as $testimonial)
                    <tr>
                      <td>{{$loop->iteration}}</td>

                      <x-table.td>{{$testimonial->name}}</x-table.td>
                        
                        <x-table.td>{{$testimonial->email}}</x-table.td>
                        
                        <x-table.td>{{$testimonial->position}}</x-table.td>

                        <x-table.switch :model="$testimonial" />

                      <td style="width:150px">
                            <div class="actions d-flex">
                                <x-table.view_btn route-view="{{route('admin.testimonials.show', ':id')}}" id="{{$testimonial->id}}" model="Testimonial" name="testimonial"/>

                                <x-table.edit_btn route-edit="{{route('admin.testimonials.edit', $testimonial->id) }}"/>

                                <x-table.delete_btn route-destroy="{{route('admin.testimonials.destroy', $testimonial->id ) }}"/>
                            </div>
                      </td>
                    </tr>

                    <x-table.show_modal id="{{$testimonial->id}}" model="Testimonial" />

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
    @include('_helpers.modal_script',['name' => 'testimonial', 'route' => route('admin.testimonials.show', ':id')])
    @include('_helpers.datatable')
    @include('_helpers.status_change', ['url' => url('Admin/status-change-testimonial')])
    @include('_helpers.swal_delete')
@endpush
