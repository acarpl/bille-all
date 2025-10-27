<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bille Southside</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0D1117;
            --bg-darker: #1C212D;
            --accent: #E63946;
            --text-light: #F8F9FA;
            --text-muted: #ADB5BD;
            --card-bg: rgba(255, 255, 255, 0.05);
            --border-color: rgba(255, 255, 255, 0.1);
            --success: #27ae60;
        }
        
        * { 
            box-sizing: border-box; 
            margin: 0; 
            padding: 0; 
        }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: linear-gradient(135deg, var(--bg-dark) 0%, var(--bg-darker) 100%);
            color: var(--text-light);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        
        .login-container {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            padding: 3rem;
            border-radius: 16px;
            width: 100%;
            max-width: 440px;
            backdrop-filter: blur(10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        
        .logo { 
            text-align: center; 
            margin-bottom: 2.5rem;
        }
        
        .logo h1 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }
        
        .text-accent {
            color: var(--accent);
        }
        
        .logo p {
            color: var(--text-muted);
            font-weight: 500;
        }
        
        .form-group { 
            margin-bottom: 1.5rem; 
        }
        
        label { 
            display: block; 
            margin-bottom: 0.75rem; 
            font-weight: 600;
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            color: var(--text-light);
            font-family: 'Plus Jakarta Sans', sans-serif;
            transition: all 0.3s ease;
        }
        
        input:focus {
            outline: none;
            border-color: var(--accent);
            background: rgba(255, 255, 255, 0.12);
        }
        
        input::placeholder {
            color: var(--text-muted);
        }
        
        .btn {
            width: 100%;
            padding: 1rem;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        .btn:hover {
            background: #d32f3d;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(230, 57, 70, 0.4);
        }
        
        .error { 
            color: var(--accent); 
            font-size: 0.875rem;
            margin-top: 0.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .error-general {
            background: rgba(230, 57, 70, 0.1);
            border: 1px solid rgba(230, 57, 70, 0.3);
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 600;
        }
        
        .links {
            text-align: center;
            margin-top: 2rem;
        }
        
        .links a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .links a:hover {
            color: #d32f3d;
        }
        
        .divider {
            text-align: center;
            margin: 1.5rem 0;
            color: var(--text-muted);
            font-weight: 500;
            position: relative;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 30%;
            height: 1px;
            background: var(--border-color);
        }
        
        .divider::before {
            left: 0;
        }
        
        .divider::after {
            right: 0;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <h1>🎱 <span class="text-accent">Bille</span> Southside</h1>
            <p>Masuk ke akun Anda</p>
        </div>
        
        <?php if (isset($errors['general'])): ?>
            <div class="error-general">
                ⚠️ <?php echo $errors['general']; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="email">ALAMAT EMAIL</label>
                <input type="email" id="email" name="email" 
                       value="<?php echo isset($old_input['email']) ? htmlspecialchars($old_input['email']) : ''; ?>" 
                       placeholder="Masukkan alamat email Anda"
                       required>
                <?php if (isset($errors['email'])): ?>
                    <div class="error">⚠️ <?php echo $errors['email']; ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="password">KATA SANDI</label>
                <input type="password" id="password" name="password" 
                       placeholder="Masukan kata sandi Anda"
                       required>
                <?php if (isset($errors['password'])): ?>
                    <div class="error">⚠️ <?php echo $errors['password']; ?></div>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn">🎯 Login</button>
        </form>
        
        <div class="divider">Baru di Southside?</div>
        
        <div class="links">
            <p>Belum memiliki akun? <a href="<?php echo Router::url('auth/register'); ?>">Buat akun</a></p>
        </div>
    </div>

    <script>
        // Add focus effects
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.style.transform = 'scale(1)';
                });
            });
        });
    </script>
</body>
</html>