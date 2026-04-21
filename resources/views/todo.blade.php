<!DOCTYPE html>
<html>
<head>
    <title>My Mini Todo App</title>
    <style>
        body { font-family: Arial; padding: 50px; background-color: #f3f4f6; }
        .container { max-width: 400px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        input { padding: 10px; width: 70%; }
        button { padding: 10px; background: black; color: white; border: none; cursor: pointer; }
        li { margin-top: 10px; display: flex; justify-content: space-between; }
        a { color: red; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">
    <h2>📝 Mini Todo List</h2>

    <form action="/add-task" method="POST">
        @csrf <input type="text" name="task_name" placeholder="Enter new task..." required>
        <button type="submit">ADD</button>
    </form>

    <hr>

    <ul>
        @foreach($tasks as $task)
            <li>
                {{ $task->title }} 
                <a href="/delete-task/{{ $task->id }}">❌</a>
            </li>
        @endforeach
    </ul>
</div>

</body>
</html>