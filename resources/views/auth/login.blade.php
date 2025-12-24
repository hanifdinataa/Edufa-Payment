<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Anime.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            background: #f2f3f7;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 1100px;
            height: 600px;
            background: #fff;
            display: flex;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,.12);
            opacity: 0;
            transform: translateY(30px);
        }

        /* LEFT IMAGE */
        .login-image {
            flex: 1;
            background: url("{{ asset('background.png') }}") center/cover no-repeat;
        }

        /* RIGHT FORM */
        .login-form {
            flex: 1;
            padding: 60px 70px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form h2 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 30px;
            color: #2b2b2b;
        }

        .form-group {
            margin-bottom: 20px;
            opacity: 0;
            transform: translateX(20px);
        }

        .form-group label {
            display: block;
            font-size: 13px;
            color: #777;
            margin-bottom: 6px;
        }

        .form-group input {
            width: 100%;
            padding: 14px 16px;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            background: #f9fafc;
            font-size: 14px;
            transition: .25s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #5a67f2;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(90,103,242,.15);
        }

        .btn-login {
            margin-top: 10px;
            padding: 14px;
            border: none;
            border-radius: 6px;
            background: #5a67f2;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: .25s;
            opacity: 0;
            transform: translateY(20px);
        }

        .btn-login:hover {
            background: #4c57e0;
        }

        /* ERROR */
        .alert {
            background: #fee2e2;
            color: #b91c1c;
            padding: 12px 14px;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .login-wrapper {
                flex-direction: column;
                height: auto;
            }

            .login-image {
                height: 260px;
            }

            .login-form {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>

<div class="login-wrapper" id="loginBox">

    <div class="login-image"></div>

    <div class="login-form">
        <h2>Login to continue</h2>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="john.doe@email.com" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <button class="btn-login" type="submit">Login</button>
        </form>
    </div>

</div>

<script>
    anime({
        targets: '#loginBox',
        opacity: [0, 1],
        translateY: [30, 0],
        duration: 800,
        easing: 'easeOutExpo'
    });

    anime({
        targets: '.form-group',
        opacity: [0, 1],
        translateX: [20, 0],
        delay: anime.stagger(120, { start: 300 }),
        easing: 'easeOutCubic'
    });

    anime({
        targets: '.btn-login',
        opacity: [0, 1],
        translateY: [20, 0],
        delay: 700,
        easing: 'easeOutCubic'
    });
</script>

</body>
</html>
