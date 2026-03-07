<x-app-layout>
    <div class="max-w-3xl mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">タスク一覧</h1>

        <form method="GET" action="{{ route('tasks.index') }}" class="flex gap-2 mb-4">
            <input
                type="text"
                name="keyword"
                value="{{ $keyword ?? '' }}"
                placeholder="タスク検索"
                class="border rounded px-3 py-2 w-full"
            >
            <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded"
            >
                検索
            </button>
        </form>

        <div class="mb-4">
            <a
                href="{{ route('tasks.create') }}"
                class="bg-green-500 text-white px-4 py-2 rounded inline-block"
            >
                新規作成
            </a>
        </div>

        <div class="bg-white shadow rounded p-4">
            @forelse ($tasks as $task)
                <div class="flex justify-between items-center border-b py-3">
                    <div>{{ $task->title }}</div>

                    <div class="flex gap-2">
                        <a
                            href="{{ route('tasks.edit', $task->id) }}"
                            class="text-blue-500"
                        >
                            編集
                        </a>

                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="text-red-500"
                                onclick="return confirm('削除しますか？')"
                            >
                                削除
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-gray-500 py-3">タスクがありません</div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $tasks->links() }}
        </div>
    </div>
</x-app-layout>
