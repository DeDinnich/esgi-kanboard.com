<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prix</th>
            <th>Options actives</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($subscriptions as $sub)
            <tr>
                <td>{{ $sub->id }}</td>
                <td>{{ $sub->name }}</td>
                <td>{{ $sub->price }} €</td>
                <td>
                    @php
                        $options = collect($sub->toArray())
                            ->filter(fn($v, $k) => str_starts_with($k, 'option') && $v);
                    @endphp
                    {{ $options->count() }} activée(s)
                </td>
                <td>
                    <a href="{{ route('admin.subscriptions.edit', $sub) }}" class="btn btn-sm btn-primary">Modifier</a>
                    <form method="POST" action="{{ route('admin.subscriptions.delete', $sub) }}" class="d-inline">@csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
