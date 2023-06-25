<!DOCTYPE html>
<html>
<head>
    <title>PNG to SVG Converter</title>
</head>
<body>
    <form method="post" action="{{ route('convert') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" accept="image/png">
        <button type="submit">Convert to SVG</button>
    </form>
</body>
</html>