<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Tasks</title>
</head>
<body>
    <h1>Tasks画面</h1>

    <a href="/tasks/create">新規作成</a>

    <ul>
        @foreach ($tasks as $task)
            <li>
                {{ $task->title }}
                <a href="/tasks/{{ $task->id }}/edit">編集</a>

                <form action="/tasks/{{ $task->id }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">削除</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
