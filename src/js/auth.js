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

            fetch('/wp-json/direx/v1/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-WP-Nonce': direxAjax.nonce,
                },
                body: JSON.stringify({
                    username: username,
                    password: password,
                }),
            })
            .then(response => {
                console.log('Raw API Response:', response);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); // Parse the response as JSON
            })
            .then(data => {
                console.log('Parsed API Response:', data);
                if (data.token) {
                    console.log('API Token:', data.token);
                    authMessage.innerHTML = `<p>Login successful! Token: ${data.token}</p>`;
                } else {
                    console.log('Error Data:', data);
                    authMessage.innerHTML = `<p>Login failed: ${data.message}</p>`;
                }
            })
            .catch(error => {
                console.error('Fetch Error:', error);
                authMessage.innerHTML = `<p>An error occurred: ${error.message}</p>`;
            });
        });
    }
});