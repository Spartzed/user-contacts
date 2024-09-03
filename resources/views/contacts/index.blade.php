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

    <div class="main-container">
        <div class="left-panel">
            <form method="GET" action="{{ route('contacts.index') }}">
                <div class="form-group">
                    <label for="search">Buscar por Nome ou CPF:</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}">
                    <button type="submit" class="search-button">
                        <img src="{{ asset('images/search-icon.png') }}" alt="Buscar">
                    </button>
                </div>
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
        </div>

        <div id="map" class="right-panel"></div>
    </div>

    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer></script>
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

    <style>
        .main-container {
            display: flex;
            height: 100vh;
            width: 100%;
        }
        .left-panel, .right-panel {
            flex: 1;
            overflow-y: auto;
        }
        .left-panel {
            padding: 20px;
            box-sizing: border-box;
        }
        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .form-group input[type="text"] {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .search-button {
            background: none;
            border: none;
            cursor: pointer;
            margin-left: 10px;
            width: 40px;
        }
        .search-button img {
            width: 20px;
            height: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        button {
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
@endsection
