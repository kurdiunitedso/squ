<table>
    <thead>
        <tr>
            <td>#</td>
            <td>name</td>
            <td>name en</td>
            <td>name hebrow</td>
            <td>ID#</td>
            <td>mobile</td>
            <td>call option</td>
            <td>call created date</td>
            <td>status</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($clientCallActions as $clientCallAction)
            <tr>
                <td>{{ ++$loop->index }}</td>
                <td>{{ $clientCallAction->client_name }}</td>

                <td>{{ $clientCallAction->client_sid}}</td>
                <td>{{ $clientCallAction->telephone }}</td>
                <td>{{ $clientCallAction->callOption->name }}</td>
                <td>{{ $clientCallAction->created_at }}</td>
                <td>{{ $clientCallAction->status ? 'true' : 'false' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
