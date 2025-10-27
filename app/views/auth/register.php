<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Bille Southside</title>
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
        
        .register-container {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            padding: 3rem;
            border-radius: 16px;
            width: 100%;
            max-width: 480px;
            backdrop-filter: blur(10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        
        .logo { 
            text-align: center; 
            margin-bottom: 2rem;
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
        
        .benefits {
            background: rgba(39, 174, 96, 0.1);
            border: 1px solid rgba(39, 174, 96, 0.3);
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
        }
        
        .benefits h4 {
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--success);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .benefits ul {
            list-style: none;
            padding: 0;
        }
        
        .benefits li {
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            color: var(--text-light);
        }
        
        .benefits li:before {
            content: "✓";
            color: var(--success);
            font-weight: bold;
            font-size: 1.1rem;
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
        
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"] {
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
        
        .optional {
            color: var(--text-muted);
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo">
            <h1>🎱 <span class="text-accent">Bille</span> Southside</h1>
            <p>Buat akun Anda</p>
        </div>
        
        <div class="benefits">
            <h4>⭐ BERGABUNG DENGAN KOMUNITAS</h4>
            <ul>
                <li>100 Loyalty Points Selamat Datang</li>
                <li>Promosi Eksklusif Khusus Member</li>
                <li>Pendaftaran Tournament Prioritas</li>
                <li>Booking & Pembayaran Digital</li>
            </ul>
        </div>
        
        <?php if (isset($errors['general'])): ?>
            <div class="error-general">
                ⚠️ <?php echo $errors['general']; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="name">NAMA LENGKAP *</label>
                <input type="text" id="name" name="name" 
                       value="<?php echo isset($old_input['name']) ? htmlspecialchars($old_input['name']) : ''; ?>" 
                       placeholder="Masukkan nama lengkap Anda"
                       required>
                <?php if (isset($errors['name'])): ?>
                    <div class="error">⚠️ <?php echo $errors['name']; ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="email">ALAMAT EMAIL *</label>
                <input type="email" id="email" name="email" 
                       value="<?php echo isset($old_input['email']) ? htmlspecialchars($old_input['email']) : ''; ?>" 
                       placeholder="Masukan alamat email Anda"
                       required>
                <?php if (isset($errors['email'])): ?>
                    <div class="error">⚠️ <?php echo $errors['email']; ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="phone">NOMOR TELEPON <span class="optional">(Opsional)</span></label>
                <input type="tel" id="phone" name="phone" 
                       value="<?php echo isset($old_input['phone']) ? htmlspecialchars($old_input['phone']) : ''; ?>"
                       placeholder="081234567890">
                <?php if (isset($errors['phone'])): ?>
                    <div class="error">⚠️ <?php echo $errors['phone']; ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="student_id">ID PELAJAR <span class="optional">(Untuk Promo Khusus Pelajar)</span></label>
                <input type="text" id="student_id" name="student_id" 
                       value="<?php echo isset($old_input['student_id']) ? htmlspecialchars($old_input['student_id']) : ''; ?>"
                       placeholder="Masukan ID pelajar Anda">
            </div>
            
            <div class="form-group">
                <label for="password">KATA SANDI *</label>
                <input type="password" id="password" name="password" 
                       placeholder="Buat kata sandi (min. 6 karakter)"
                       required>
                <?php if (isset($errors['password'])): ?>
                    <div class="error">⚠️ <?php echo $errors['password']; ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="password_confirm">KONFIRMASI KATA SANDI *</label>
                <input type="password" id="password_confirm" name="password_confirm" 
                       placeholder="Konfirmasi kata sandi Anda"
                       required>
                <?php if (isset($errors['password_confirm'])): ?>
                    <div class="error">⚠️ <?php echo $errors['password_confirm']; ?></div>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn">🚀 Buat Akun</button>
        </form>
        
        <div class="links">
            <p>Sudah memiliki akun? <a href="<?php echo Router::url('auth/login'); ?>">Sign in here</a></p>
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

            // Real-time password confirmation check
            const password = document.getElementById('password');
            const passwordConfirm = document.getElementById('password_confirm');
            
            function checkPasswordMatch() {
                if (password.value && passwordConfirm.value) {
                    if (password.value !== passwordConfirm.value) {
                        passwordConfirm.style.borderColor = 'var(--accent)';
                    } else {
                        passwordConfirm.style.borderColor = 'var(--success)';
                    }
                }
            }
            
            password.addEventListener('input', checkPasswordMatch);
            passwordConfirm.addEventListener('input', checkPasswordMatch);
        });
    </script>
</body>
</html>