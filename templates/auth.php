<div class="wrap auth-wrap">
    <div class="auth-container">
        <div class="auth-header">
            <h1>Welcome Back</h1>
            <p>Login to access your account</p>
        </div>
        <form id="auth-form" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" id="login-button" class="button button-primary">Login</button>
        </form>
        <div id="auth-message"></div>
    </div>
</div>