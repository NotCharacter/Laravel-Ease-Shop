<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
<script>
        // Toggle mobile menu
        document.getElementById('mobile-menu-button').addEventListener('click', () => {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
            sidebar.classList.toggle('-translate-x-full');
        });

        // Toggle dropdowns
        document.querySelectorAll('.dropdown').forEach(dropdown => {
            dropdown.querySelector('button').addEventListener('click', () => {
                const content = dropdown.querySelector('.dropdown-content');
                content.classList.toggle('hidden');
                
                // Rotate chevron icon
                const chevron = dropdown.querySelector('.fa-chevron-down');
                chevron.classList.toggle('rotate-180');
            });
        });
    </script>
    
</body>
</html>