<html>
    <head>
        <title>Добавление пользователя</title>
        <link rel="stylesheet" type="text/css" href="/css/add_user.css">
    </head>

<body>
    <div class="AddHead">Добавление пользователя</div>
    <div class="blockInput">
        <div>
        <div class="leftLabel">
            Логин:
        </div>
        <div class="dataUser">
            <input type="text" id="login" class="input addInput" placeholder="Укажите логин">
        </div>
        </div>
        <div>
        <div class="leftLabel">
            Пароль:
        </div>
        <div class="dataUser">
            <input type="password" id="password" class="input addInput" placeholder="Укажите пароль">
        </div>
        </div>
        <div>
        <div class="leftLabel">
            Повтор пароля:
        </div>
        <div class="dataUser">
            <input type="password" id="confirmPassword" class="input addInput" placeholder="Повторите пароль">
        </div>
            </div>

        <div>
            <div class="leftLabel">
                Email:
            </div>
            <div class="dataUser">
                <input type="email" id="email" class="input addInput" placeholder="Укажите адрес электронной почты">
            </div>
        </div>

        <div>
            <div class="leftLabel">
                Права доступа:
            </div>
            <div class="dataUser">
                <select id="permission" onchange='changePermission(this)' class="input addInput">
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

            <button style="margin-top: 20px" onclick="addUser()" class="button addInput">Добавить</button>
        <div id="error"></div>
    </div>
    <script type="text/javascript" src="/js/ajax.js"></script>
<script type="text/javascript" src="/js/add_student.js"></script>
</body>
</html>