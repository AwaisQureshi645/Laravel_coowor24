<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .login-container {
            background-color: rgba(255, 255, 255, 1);
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 400px;
        }
        
        .sign-in-btn {
            background-color: #FF8C00;
            color: white;
            padding: 0.75rem;
            border-radius: 4px;
            width: 100%;
            font-weight: 500;
            transition: background-color 0.3s;
        }
        
        .sign-in-btn:hover {
            background-color: #FF7400;
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-top: 0.5rem;
        }
        
        .forget-password {
            color: #0000EE;
            text-decoration: none;
        }
        
        .forget-password:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="login-container">
        <h1 class="text-2xl font-bold mb-6 text-center">Sign In</h1>
        
        <form method="POST"  action="/login">
            
            
            <div class="mb-4">
                <label for="username" class="block text-red-800">Username:</label>
                <input type="text" id="username" name="username" class="form-input @error('username') border-red-500 @enderror" required autofocus>
               
            </div>
            
            <div class="mb-4">
                <label for="password" class="block text-red-800">Password:</label>
                <input type="password" id="password" name="password" class="form-input @error('password') border-red-500 @enderror" required>
                
            </div>
            
            <div class="mb-4 text-center">
                <a href="{{ route('password.request') }}" class="forget-password">Forget Password?</a>
            </div>
            
            <button type="submit" class="sign-in-btn">Sign In</button>
        </form>
    </div>
</body>
</html>