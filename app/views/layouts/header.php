<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' - Bille Southside' : 'Bille Southside'; ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo Router::asset('css/style.css'); ?>">
    <style>
        :root {
            --bg-dark: #0D1117;
            --bg-darker: #1C212D;
            --accent: #E63946;
            --text-light: #F8F9FA;
            --text-muted: #ADB5BD;
            --card-bg: rgba(255, 255, 255, 0.05);
            --border-color: rgba(255, 255, 255, 0.1);
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
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 700;
            line-height: 1.2;
        }
        
        .text-accent {
            color: var(--accent);
        }
        
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: var(--accent);
            color: white;
        }
        
        .btn-primary:hover {
            background: #d32f3d;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(230, 57, 70, 0.3);
        }
        
        .btn-outline {
            background: transparent;
            color: var(--text-light);
            border: 2px solid var(--accent);
        }
        
        .btn-outline:hover {
            background: var(--accent);
            transform: translateY(-2px);
        }
        
        .card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 2rem;
            backdrop-filter: blur(10px);
        }

        .translate-wrapper {
      display: inline-block;
      position: relative;
      top: 2px;
    }

    .goog-te-gadget {
      font-size: 0 !important;
    }

    .goog-te-gadget select {
      background: transparent;
      border: none;
      font-size: 14px;
      color: white;
      cursor: pointer;
    }

    .goog-logo-link {
      display: none !important;
    }

    .goog-te-banner-frame.skiptranslate {
      display: none !important;
    }
    </style>
    <script type="text/javascript">
  function googleTranslateElementInit() {
    new google.translate.TranslateElement({
      pageLanguage: 'en', // bahasa asli websitemu
      includedLanguages: 'id,en', // target: Indonesia & Inggris
      layout: google.translate.TranslateElement.InlineLayout.SIMPLE
    }, 'google_translate_element');
  }
</script>
<script type="text/javascript"
  src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit">
</script>
</head>
<body>