document.addEventListener('DOMContentLoaded', () => {
    console.log('auth.js loaded');
    
    const authForm = document.getElementById('auth-form');
    const authMessage = document.getElementById('auth-message');

    if (authForm) {
        authForm.addEventListener('submit', (e) => {
            e.preventDefault();

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            console.log('Form submitted', { username, password });

            // Create FormData and append necessary fields
            const formData = new FormData();
            formData.append('action', 'direx_auth');
            formData.append('username', username);
            formData.append('password', password);
            formData.append('nonce', direxAjax.nonce); // Pass nonce correctly

            fetch(direxAjax.ajaxurl, {
                method: 'POST',
                body: formData, // No need for JSON.stringify()
            })
            .then(response => response.json()) // Parse JSON response
            .then(data => {
                console.log('Parsed API Response:', data);
                if (data.success) {
                    console.log('API Token:', data.data.token);
                    authMessage.innerHTML = `<p>Login successful! Token: ${data.data.token}</p>`;
                } else {
                    console.log('Error Data:', data.data);
                    authMessage.innerHTML = `<p>Login failed: ${data.data.message}</p>`;
                }
            })
            .catch(error => {
                console.error('Fetch Error:', error);
                authMessage.innerHTML = `<p>An error occurred: ${error.message}</p>`;
            });
        });
    }
});
