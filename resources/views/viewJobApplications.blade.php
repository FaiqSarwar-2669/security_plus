<!DOCTYPE html>
<html>

<head>
    <title>Laravel PDF</title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }

        body {
            padding: 10px;
        }

        h1 {
            display: block;
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

        .job-application-container {
            padding: 30px;
        }

        .job-application-container .job-heading label {
            font-size: 18px;
            display: block;
            text-align: center;
            font-weight: bold;
        }

        .job-data {
            display: flex;
            justify-content: space-between;
        }

        .job-data .job-content {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .job-data .job-content .label-input label,
        .job-data .job-content .check-box label,
        .job-data .job-content .radio-box label {
            font-size: 17px;
            font-weight: bold;
        }

        .job-data .job-content .label-input label span,
        .job-data .job-content .check-box label span,
        .job-data .job-content .radio-box label span {
            font-size: 15px;
            font-weight: normal;
        }
    </style>
</head>

<body>
    <h1>Security Plus</h1>
    <div class="header">
        <div class="header-part1">
            <!-- <div>
                <label>Application Id: #12</label><br>
            </div>
            <div>
                <label>Date: 25/23/2034</label><br>
            </div>
            <div>
                <label>Organization Name: Rathore construnction</label><br>
            </div> -->
        </div>
        <div class="header-part2">
            <!-- <img src="{{ $logo }}" alt="image"> -->
        </div>
    </div>
    <div class="job-application-container">
        <div class="job-heading">
            <label>Job Application Data</label>
        </div>
        <div class="job-data">
            <div class="job-content">
                @foreach($data as $item)
                @if($item->type == 'Input' || $item->type == 'Label')
                <div class="label-input">
                    @if($item->type == 'Label')
                    <label>{{ $item->text }}</label>
                    @elseif($item->type == 'Input')
                    <span>{{$item->data}}</span>
                    @endif
                </div>
                @elseif($item->type == 'Checkbox')
                <div class="check-box">
                    <label>{{ $item->text }}</label><br>
                    @foreach($item->options as $option)
                    <span>{{ $option }}</span><br>
                    @endforeach
                </div>
                @elseif($item->type == 'Radio Button')
                <div class="radio-box">
                    <label>{{ $item->text }}: <span>{{ $item->data }}</span></label>
                </div>
                @endif
                @endforeach
            </div>
            <div class="job-image">

            </div>
        </div>
    </div>

</body>

</html>