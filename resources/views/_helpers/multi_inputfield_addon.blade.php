<script>
    function addInputFields() {
        // Create a new div container for the input fields
        var newInputContainer = document.createElement('div');
        newInputContainer.classList.add('input-container','d-flex');

        // Create new input elements for "name" and "price"
        var nameInput = document.createElement('input');
        nameInput.type = 'text';
        nameInput.name = 'name[]';
        nameInput.placeholder = 'Enter name';
        nameInput.classList.add('form-control', 'me-2', 'w-50');
        nameInput.classList.add('mt-2');

       
        newInputContainer.appendChild(nameInput);
        // Create a delete button for the new set
        var deleteButton = document.createElement('button');
        var iconElement = document.createElement('i');
        iconElement.className = 'bx bx-trash';
        iconElement.textContent = '';
        deleteButton.appendChild(iconElement);
        deleteButton.onclick = function() {
            removeInputFields(this);
        };
        deleteButton.classList.add('btn', 'btn-danger');
        deleteButton.classList.add('mt-2');
        newInputContainer.appendChild(deleteButton);

        // Append the new div container to the main container
        document.getElementById('inputContainer').appendChild(newInputContainer);
    }

    function removeInputFields(button) {
        // Get the parent div container and remove it
        var container = button.parentNode;
        container.parentNode.removeChild(container);
    }
</script>
