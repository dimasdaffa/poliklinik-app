<x-layouts.app title="Dashboard Admin">
    <h1>Selamat Datang Admin</h1>
<form method="POST" action="/logout">
@csrf
<button type="submit">Logout</button>
</form>
</x-layouts.app>
