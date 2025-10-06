<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Bille Southside</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .register-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 450px;
        }
        .logo { 
            text-align: center; 
            margin-bottom: 1.5rem;
            color: #333;
        }
        .form-group { margin-bottom: 1rem; }
        label { 
            display: block; 
            margin-bottom: 0.5rem; 
            font-weight: 600;
            color: #555;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"] {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        input:focus {
            outline: none;
            border-color: #667eea;
        }
        .btn {
            width: 100%;
            padding: 0.75rem;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #5a6fd8;
        }
        .error { 
            color: #e74c3c; 
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .links {
            text-align: center;
            margin-top: 1rem;
        }
        .links a {
            color: #667eea;
            text-decoration: none;
        }
        .links a:hover {
            text-decoration: underline;
        }
        .benefits {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }
        .benefits ul {
            list-style: none;
            padding: 0;
        }
        .benefits li {
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }
        .benefits li:before {
            content: "✓";
            color: #27ae60;
            font-weight: bold;
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo">
            <h1>🎱 Bille Southside</h1>
            <p>Create your account</p>
        </div>
        
        <div class="benefits">
            <p><strong>Join us and get:</strong></p>
            <ul>
                <li>100 Loyalty Points</li>
                <li>Easy booking & payments</li>
                <li>Exclusive member promotions</li>
                <li>Tournament registration</li>
            </ul>
        </div>
        
        <?php if (isset($errors['general'])): ?>
            <div class="error" style="background: #fee; padding: 0.5rem; border-radius: 5px; margin-bottom: 1rem;">
                <?php echo $errors['general']; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="name">Full Name *</label>
                <input type="text" id="name" name="name" 
                       value="<?php echo isset($old_input['name']) ? $old_input['name'] : ''; ?>" 
                       required>
                <?php if (isset($errors['name'])): ?>
                    <div class="error"><?php echo $errors['name']; ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" 
                       value="<?php echo isset($old_input['email']) ? $old_input['email'] : ''; ?>" 
                       required>
                <?php if (isset($errors['email'])): ?>
                    <div class="error"><?php echo $errors['email']; ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" 
                       value="<?php echo isset($old_input['phone']) ? $old_input['phone'] : ''; ?>"
                       placeholder="081234567890">
                <?php if (isset($errors['phone'])): ?>
                    <div class="error"><?php echo $errors['phone']; ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="student_id">Student ID (for Student Promo)</label>
                <input type="text" id="student_id" name="student_id" 
                       value="<?php echo isset($old_input['student_id']) ? $old_input['student_id'] : ''; ?>"
                       placeholder="Optional">
            </div>
            
            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" id="password" name="password" required>
                <?php if (isset($errors['password'])): ?>
                    <div class="error"><?php echo $errors['password']; ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="password_confirm">Confirm Password *</label>
                <input type="password" id="password_confirm" name="password_confirm" required>
                <?php if (isset($errors['password_confirm'])): ?>
                    <div class="error"><?php echo $errors['password_confirm']; ?></div>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn">Create Account</button>
        </form>
        
        <div class="links">
            <p>Already have an account? <a href="<?php echo Router::url('auth/login'); ?>">Sign in</a></p>
        </div>
    </div>
</body>
</html>