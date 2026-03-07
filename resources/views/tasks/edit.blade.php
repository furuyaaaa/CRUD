<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>編集</title>
</head>
<body>
    <h1>タスク編集</h1>

    <form action="/tasks/{{ $task->id }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="title" value="{{ $task->title }}">
        <button type="submit">更新</button>
    </form>

    <a href="/tasks">一覧へ戻る</a>
</body>
</html>