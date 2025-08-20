document.addEventListener('DOMContentLoaded', function() {
    const likeForms = document.querySelectorAll('[data-like]');

    likeForms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();

            const url = form.getAttribute('data-action');
            const formData = new FormData(form);

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest', // Для Laravel может потребоваться
                    'X-CSRF-TOKEN': csrfToken,
                },
            })
                .then(response => response.json())
                .then(data => {
                    const likesElement = document.getElementById('likes-' + data.id);
                    if (likesElement) {
                        likesElement.innerHTML = `<i class="fa-solid fa-heart"></i> ${data.likes} Like`;

                        if(data.status === 'liked') {
                            likesElement.classList.add('text-primary');
                        } else {
                            likesElement.classList.remove('text-primary')
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

            return false;
        });
    });
});
