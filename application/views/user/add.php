<html>
    <head>
        <title>Добавление пользователя</title>
        <link rel="stylesheet" type="text/css" href="/css/inputs.css">
        <link rel="stylesheet" type="text/css" href="/css/buttons.css">
        <link rel="stylesheet" type="text/css" href="/css/titles.css">
    </head>

<body>
    <div class="title">Добавление пользователя</div>
    <div class="blockInput">
        <div>
            <div class="leftLabel">
                Имя:
            </div>
            <div class="dataUser">
                <input type="text" id="name" class="input" placeholder="Укажите имя">
            </div>
        </div>
        <div>
        <div class="leftLabel">
            Логин:
        </div>
        <div class="dataUser">
            <input type="text" id="login" class="input" placeholder="Укажите логин">
        </div>
        </div>
        <div>
        <div class="leftLabel">
            Пароль:
        </div>
        <div class="dataUser">
            <input type="password" id="password" class="input" placeholder="Укажите пароль">
        </div>
        </div>
        <div>
        <div class="leftLabel">
            Повтор пароля:
        </div>
        <div class="dataUser">
            <input type="password" id="confirmPassword" class="input" placeholder="Повторите пароль">
        </div>
            </div>

        <div>
            <div class="leftLabel">
                Email:
            </div>
            <div class="dataUser">
                <input type="email" id="email" class="input" placeholder="Укажите адрес электронной почты">
            </div>
        </div>

        <div>
            <div class="leftLabel">
                Права доступа:
            </div>
            <div class="dataUser">
                <select id="permission" onchange='changePermission(this)' class="input">
                    <option selected disabled value="">Выберите права доступа:</option>
                <?php
                foreach (UserTypes::ARRAY as $key=>$value) {
                    printf("<option value='%s'>%s</option>", $key,$value);
                }
                ?>
                    </select>
            </div>
        </div>
        <div id="addon">

        </div>

        <div>
            <div class="leftLabel">
            </div>
            <div class="dataUser">
                <button onclick="window.history.back();" class="button control_button cancel_button">Отменить</button>
                <button style="margin-top: 20px" onclick="addUser()" class="button control_button ok_button">Добавить</button>
            </div>
        </div>
        <div id="error"></div>
    </div>
    <script type="text/javascript" src="/js/ajax.js"></script>
<script type="text/javascript" src="/js/add_user.js"></script>
</body>
</html>