<script>

    $(document).on('click', '.deleteGalleryImage', function (e) {
        e.preventDefault();

        // Store reference to the delete button clicked
        const deleteButton = $(this);

        // Ask for confirmation before proceeding
        const confirmation = confirm("Are you sure you want to delete this image?");
        
        if (confirmation) {
            const dataId = deleteButton.data('id');
            const imageName = deleteButton.data('image');

            const url = "{{route('admin.delete-gallery-image')}}";

            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                    gallery_id: dataId,
                    image_name: imageName,
                    folder: "{{$folder}}"
                },
                success: function (response) {
                    location.reload();
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        } else {
            // If cancelled, do nothing
            console.log("Deletion cancelled.");
        }
    });

</script>
