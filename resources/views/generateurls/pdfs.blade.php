<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Generated URLs</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>

<h3>Generated Short URLs</h3>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Short Code</th>
            <th>Long URL</th>
            <th>Clicks</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($genurls as $index => $url)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $url->short_code }}</td>
            <td>{{ $url->long_url }}</td>
            <td>{{ $url->clicks }}</td>
           <td>{{ $url->created_at->format('d M Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
