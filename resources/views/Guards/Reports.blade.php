<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guard Attendance Record</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            text-align: center;
        }

        .header {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid gray;
            align-items: center;
        }

        .header-part2 {
            width: 150px;
            height: 150px;
            overflow: hidden;
        }

        .header-part1 {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .header-part1 label {
            font-size: 18px;
            font-weight: bold;
        }

        .header-part2 img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
        }

        .container {
            margin: 20px auto;
            width: 90%;
            max-width: 1200px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td {
            color: #333;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }

        @media screen and (max-width: 768px) {

            table,
            th,
            td {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="header-part2">
            <img src="{{$image}}" alt="image">
        </div>
        <div class="header-part1">
            <div>
                <label>Security-Plus</label><br>
            </div>
            <div>
                <label>Application Id: #{{$id}}</label><br>
            </div>
            <div>
                <label>Date: {{$Day}}</label><br>
            </div>
        </div>
    </div>
    <div class="container">
        <h1>Guard Attendance Record</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Beep 1</th>
                    <th>Beep 2</th>
                    <th>Beep 3</th>
                    <th>Beep 4</th>
                    <th>Beep 5</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td>{{$item->Name}}</td>
                    <td>{{$item->Alert1}}</td>
                    <td>{{$item->Alert2}}</td>
                    <td>{{$item->Alert3}}</td>
                    <td>{{$item->Alert4}}</td>
                    <td>{{$item->Alert5}}</td>
                    <td>{{$item->Percentage}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</body>

</html>