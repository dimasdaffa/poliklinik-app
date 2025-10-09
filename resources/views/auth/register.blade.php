<h2>Register</h2>

@if ($errors->any())
    <ul style="color: red">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>

@endif

<form method="POST" action="{{ route('register') }}">
    @csrf
    <label for="">Nama Lengkap:</label><br>
    <input type="text" name="nama" required><br>
    <label for="">Email:</label><br>
    <input type="email" name="email" required><br>
    <label for="">Alamat:</label><br>
    <input type="text" name="alamat" required><br>
    <label for="">No HP:</label><br>
    <input type="text" name="no_hp" required><br>
    <label for="">No KTP:</label><br>
    <input type="text" name="no_ktp" required><br>
    <label for="">Password:</label><br>
    <input type="password" name="password" required><br>
    <label for="">Confirm Password:</label><br>
    <input type="password" name="password_confirmation" required><br>
    <button type="submit">Daftar</button>

</form>

<p>Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
