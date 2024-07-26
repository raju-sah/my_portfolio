<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Package Report</title>
    <style>
        body {
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont,
                Segoe UI, Roboto, Oxygen, Ubuntu, Cantarell, Fira Sans,
                Droid Sans, Helvetica, Arial, sans-serif !important;
        }

        table {
            border-collapse: collapse;

            width: 100%;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .main_title {
            background-color: #ffffff;
        }

        .main_titles {
            font-size: large;
            border-bottom: 1px solid #ddd;
        }

        h4 {
            margin: 0;
        }
    </style>
</head>

<body>
    @if ($filtered_article)
        <table>
            <thead>
                <tr class="main_titles">
                    <th class="main_title">{{ $filtered_article->name }}</th>
                    <th class="main_title">{{ $filtered_article->views }} Views</th>
                    <th class="main_title">
                        ({{ $filtered_article->reviews_avg_rating }}/5{{ Str::plural('Star', $filtered_article->reviews_avg_rating) }})
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div>
                            <h4>Min Read:</h4>
                        </div>
                        <div>{{ $filtered_article->min_read }}</div>
                    </td>
                    <td>
                        <div>
                            <h4>About:</h4>
                        </div>
                        <div>{{ $filtered_article->about }}</div>
                    </td>
                </tr>
            </tbody>
        </table>

        <!----------------- Reviews Section -------------------------------->
        <table>
            <caption
                style="
                    font-size: large;
                    font-weight: bold;
                    border-bottom: 1px solid #ddd;
                    border-top: 1px solid #ddd;
                    padding: 10px;
                ">
                Reviews({{ $filtered_article->reviews_count }})
            </caption>

            <caption style="border-bottom: 1px solid #ddd; padding: 10px">
                Top (3) Highest Ratings
            </caption>

            <thead>
                <tr>
                    <th>FULL NAME</th>
                    <th>EMAIL</th>
                    <th>RATING</th>
                    <th>CREATED AT</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($highest_ratings as $highest_rating)
                    <tr>
                        <td>{{ $highest_rating->name }}</td>
                        <td>{{ $highest_rating->email }}</td>
                        <td>{{ $highest_rating->rating }}/5 {{ Str::plural('Star', $highest_rating->rating) }}</td>
                        @php
                            $formattedDate = $highest_rating->created_at->format('dS M Y g:i A');
                        @endphp
                        <td>{{ $formattedDate }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        <!----------------- Top 3 Highest Ratings Section -------------------------------->
        <table>
            <caption
                style="
                    border-bottom: 1px solid #ddd;
                    border-top: 1px solid #ddd;
                    padding: 10px;
                ">
                Top (3) Lowest Ratings
            </caption>
            <thead>
                <tr>
                    <th>FULL NAME</th>
                    <th>EMAIL</th>
                    <th>RATING</th>
                    <th>CREATED AT</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lowest_ratings as $lowest_rating)
                    <tr>
                        <td>{{ $lowest_rating->name }}</td>
                        <td>{{ $lowest_rating->email }}</td>
                        <td>{{ $lowest_rating->rating }}/5 {{ Str::plural('Star', $lowest_rating->rating) }}</td>
                        @php
                            $formattedDate = $lowest_rating->created_at->format('dS M Y g:i A');
                        @endphp
                        <td>{{ $formattedDate }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <!----------------- Top 3 Lowest Ratings Section -------------------------------->

        <table>
            <caption
                style="
                    border-bottom: 1px solid #ddd;
                    border-top: 1px solid #ddd;
                    padding: 10px;
                ">
                Top (5) Latest Ratings
            </caption>
            <thead>
                <tr>
                    <th>FULL NAME</th>
                    <th>EMAIL</th>
                    <th>RATING</th>
                    <th>CREATED AT</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($latest_ratings as $latest_rating)
                    <tr>
                        <td>{{ $latest_rating->name }}</td>
                        <td>{{ $latest_rating->email }}</td>
                        <td>{{ $latest_rating->rating }}/5 {{ Str::plural('Star', $latest_rating->rating) }}</td>
                        @php
                            $formattedDate = $latest_rating->created_at->format('dS M Y g:i A');
                        @endphp
                        <td>{{ $formattedDate }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>

</html>
