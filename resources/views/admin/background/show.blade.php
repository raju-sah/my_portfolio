<table class="table table-hover table-striped">

    <tbody>
        <tr>
            <td class="text-uppercase text-14">Image</td>
            <td ><img src="{{$background->image_path}}" height="100px" width="100px" alt="image"></td>
            
          </tr>
        <tr>
            <td class="text-uppercase text-14"> name</td>
            <td>{{ $background->name ?? '' }}</td>

        </tr>
        <tr>
            <td class="text-uppercase text-14">slug</td>
            <td>{{ $background->slug ?? '' }}</td>

        </tr>
        <tr>
            <td class="text-uppercase text-14">address</td>
            <td>{{ $background->address ?? '' }}</td>

        </tr>
        <tr>
            <td class="text-uppercase text-14">map_url</td>
            <td>{{ $background->map_url ?? '' }}</td>

        </tr>
        <tr>
            <td class="text-uppercase text-14">web_url</td>
            <td>{{ $background->web_url ?? '' }}</td>

        </tr>
       
        

        <tr>
            <td class="text-uppercase text-14">description</td>
            <td>{!! $background->description ?? '' !!}</td>

        </tr>



        <tr>
            <td class="text-uppercase text-14">status</td>
            <td>{{ $background->status == 1 ? 'Active' : 'Inactive' }}</td>

        </tr>
        <tr>
            <td class="text-uppercase text-14">created_at</td>
            <td>{{ $background->created_at }}</td>

        </tr>
        <tr>
            <td class="text-uppercase text-14">updated_at</td>
            <td>{{ $background->updated_at }}</td>

        </tr>
    </tbody>


    <style>
        .text-uppercase {
            font-weight: 800;
        }

        tr:nth-child(even) {
            background-color: #dee2e6;
        }
    </style>
</table>
