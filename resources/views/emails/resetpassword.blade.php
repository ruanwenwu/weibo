<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>密码重设确认链接</title>
</head>
<body>
<h1>您正在使用weibo的密码重设功能修改密码！</h1>

<p>
    请点击下面的链接修改密码：
    <a href="{{ route('password.showResetForm', $user->token) }}">
        {{ route('password.showResetForm', $user->token) }}
    </a>
</p>

<p>
    如果这不是您本人的操作，请忽略此邮件。
</p>
</body>
</html>