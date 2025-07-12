<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h1 { text-align: center; }
        h2 { margin-top: 20px; }
        p { text-align: center; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <h1>Academic Ranking Report</h1>
    <h2>IPS Major</h2>
    <p>Ranking based on average grades for semesters 1-5</p>
    <table>
        <thead>
            <tr>
                <th>Rank</th>
                <th>NIS</th>
                <th>Name</th>
                <th>Class</th>
                <th>Average Grade</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ipsRankings as $ranking)
                <tr>
                    <td>{{ $ranking['rank'] }}</td>
                    <td>{{ $ranking['nis'] }}</td>
                    <td>{{ $ranking['name'] }}</td>
                    <td>{{ $ranking['class'] }}</td>
                    <td>{{ $ranking['average_grade'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">No data available for IPS</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>