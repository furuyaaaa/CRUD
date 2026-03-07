<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規作成</title>
</head>
<body>
    <h1>タスク新規作成</h1>

    <form action="/tasks" method="POST">
        @csrf
        <input type="text" name="title" placeholder="タスク名">
        <button type="submit">保存</button>
    </form>

    <a href="/tasks">一覧へ戻る</a>
</body>
</html>