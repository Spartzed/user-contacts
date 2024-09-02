<!DOCTYPE html>
<html>
<head>
    <title>Contatos</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY"></script> --}}
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -25.4284, lng: -49.2733},
                zoom: 12
            });

            @foreach ($contacts as $contact)
                new google.maps.Marker({
                    position: {lat: {{ $contact->latitude }}, lng: {{ $contact->longitude }}},
                    map: map,
                    title: '{{ $contact->name }}'
                });
            @endforeach
        }
    </script>
</head>
<body onload="initMap()">
    <h2>Contatos</h2>

    <form method="GET" action="{{ route('contacts.index') }}">
        <div>
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name" value="{{ request('name') }}">
        </div>
        <div>
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" value="{{ request('cpf') }}">
        </div>
        <button type="submit">Filtrar</button>
    </form>

    <ul>
        @foreach ($contacts as $contact)
            <li>
                {{ $contact->name }} - {{ $contact->phone }} - {{ $contact->address }} - {{ $contact->cep }}
            </li>
        @endforeach
    </ul>

    <div id="map" style="height: 500px; width: 100%;"></div>
</body>
</html>
