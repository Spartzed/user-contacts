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

    <h1>Contatos</h1>

    <div class="main-container">
        <div class="left-panel">
            <form method="GET" action="{{ route('contacts.index') }}">
                <div class="form-group search-name">
                    <label for="search">Buscar por nome ou CPF:</label>
                    <div class="input-content">
                        <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Digite o nome ou CPF">
                        <button type="submit" class="search-button">
                            <img src="{{ asset('images/search.svg') }}" alt="Buscar">
                            Buscar
                        </button>
                    </div>
                </div>
            </form>

            <button onclick="window.location.href='{{ route('contacts.create') }}'" class="create-button">Criar contato</button>
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

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCpAyFtAASJ7X3sl43jydvD_8YobTjRtzk&callback=initMap" async defer></script>
    <script>
        let map;
        let markers = [];
    
        function initMap() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };
                        map = new google.maps.Map(document.getElementById('map'), {
                            center: userLocation,
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
                        centralizarMapa(userLocation.lat, userLocation.lng);
                    },
                    () => {
                        initMapWithFixedLocation();
                    }
                );
            } else {
                initMapWithFixedLocation();
            }
        }
    
        function initMapWithFixedLocation() {
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
        h1 {
            padding: 20px 0px 0px 20px;
        }
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
        .form-group.search-name {
            align-items: stretch;
            flex-direction: column
        }
        .form-group .input-content {
            display: flex;
        }

        .search-button {
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            margin-left: 10px;
            display: flex;
            align-items: center;
        }

        .search-button:hover {
            background-color: #0056b3;
        }

        .search-button img {
            width: 15px;
            height: 15px;
            margin-right: 5px;
        }

        .create-button {
            margin-top: 20px;
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
