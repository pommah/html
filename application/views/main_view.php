<html>
    <head>
        <title>Вход в систему</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <link rel="stylesheet" type="text/css" href="css/auth.css">
    </head>
    <body>
        <div class="outer">
            <div class="auth_block">
                <div class="head_auth">
                    Вход в систему
                </div>
                <div class="auth_fields">
                    <div id="error_line"></div>
                    <input type="text" class="input authInput" id="login" placeholder="Логин" maxlength="18"><br>
                    <input type="password" class="input authInput" id="password" placeholder="Пароль" maxlength="18"><br>
                    <button class="button authButton" onclick="checkAuth()">Войти</button>
                    <div class="forget_pass">
                        <a class="forget_href" href="forgetpass">Забыли пароль?</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="foot">Система учета и сопровождения в процессе получения высшего образования лиц с инвалидностью</div>
    </body>
    <script type="text/javascript" src="/js/ajax.js"></script>
    <script type="text/javascript" src="/js/checkAuth.js"></script>
</html>