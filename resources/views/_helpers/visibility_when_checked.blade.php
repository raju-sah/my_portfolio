<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initially hide or show the 'date_to' input based on the checkbox state
        toggleDateToVisibility();
    
        // Attach an event listener to the checkbox to toggle visibility
        document.getElementById('exampleCheckbox').addEventListener('change', function () {
            toggleDateToVisibility();
        });
    
        // Function to toggle visibility of 'date_to' input based on checkbox state
        function toggleDateToVisibility() {
            var dateToInput = document.getElementById('date_to');
            var checkbox = document.getElementById('exampleCheckbox');
    
            if (checkbox.checked) {
                dateToInput.style.display = 'none';
            } else {
                dateToInput.style.display = 'block';
            }
        }
    });
    </script>