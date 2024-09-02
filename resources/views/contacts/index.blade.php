@extends('layouts.app')

@section('title', 'Contatos')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2>Contatos</h2>

    <form method="GET" action="{{ route('contacts.index') }}">
        <div>
            <label for="search">Buscar por Nome ou CPF:</label>
            <input type="text" id="search" name="search" value="{{ request('search') }}">
        </div>
        <button type="submit">Filtrar</button>
    </form>
    <button onclick="window.location.href='{{ route('contacts.create') }}'">Criar Contato</button>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contacts as $contact)
                <tr>
                    <td>
                        <a href="#" onclick="centralizarMapa({{ $contact->latitude }}, {{ $contact->longitude }})">
                            {{ $contact->name }}
                        </a>
                    </td>
                    <td>
                        <button onclick="window.location.href='{{ route('contacts.edit', $contact->id) }}'">Editar</button>
                        <form method="POST" action="{{ route('contacts.destroy', $contact->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este contato?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div id="map" style="height: 500px; width: 100%;"></div>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaa_Vmxvv2qvNNHp2PB4zXwyKasMxFzcE&callback=initMap" async defer></script>
    <script>
        let map;
        let markers = [];

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -25.4284, lng: -49.2733},
                zoom: 12
            });

            @foreach ($contacts as $contact)
                var marker = new google.maps.Marker({
                    position: {lat: {{ $contact->latitude }}, lng: {{ $contact->longitude }}},
                    map: map,
                    title: '{{ $contact->name }}'
                });
                markers.push(marker);
            @endforeach
        }

        function centralizarMapa(lat, lng) {
            map.setCenter({lat: lat, lng: lng});
            map.setZoom(15);
        }
    </script>
@endsection
