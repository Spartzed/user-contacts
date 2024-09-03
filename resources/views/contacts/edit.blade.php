@extends('layouts.app')

@section('title', 'Criar Contato')

@section('content')
    <div class="container">
        <h2 class="title">Cadastro de Contatos</h2>

        @if ($errors->any())
            <div class="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('contacts.update', $contact->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" value="{{ $contact->name }}" required>
            </div>
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" value="{{ $contact->cpf }}" oninput="limparFormatacao(event)" required>
            </div>
            <div class="form-group">
                <label for="phone">Telefone:</label>
                <input type="text" id="phone" name="phone" value="{{ $contact->phone }}" required>
            </div>
            <div class="form-group">
                <label for="uf">UF:</label>
                <input type="text" id="uf" name="uf" value="{{ $contact->uf }}" oninput="buscarEndereco()" required>
            </div>
            <div class="form-group">
                <label for="cidade">Cidade:</label>
                <input type="text" id="cidade" name="cidade" value="{{ $contact->cidade }}" oninput="buscarEndereco()" required>
            </div>
            <div class="form-group">
                <label for="logradouro">Logradouro:</label>
                <input type="text" id="logradouro" name="logradouro" value="{{ $contact->logradouro }}" oninput="buscarEndereco()" required>
            </div>
            <div class="form-group">
                <label for="numero">Número:</label>
                <input type="text" id="numero" name="numero" value="{{ $contact->numero }}" required>
            </div>
            <div class="form-group">
                <label for="bairro">Bairro:</label>
                <input type="text" id="bairro" name="bairro" value="{{ $contact->bairro }}" required>
            </div>
            <div class="form-group">
                <label for="cep">CEP:</label>
                <input type="text" id="cep" name="cep" value="{{ $contact->cep }}" oninput="limparFormatacao(event); buscarEnderecoPorCep()" required>
            </div>
            <div class="form-group">
                <label for="complemento">Complemento:</label>
                <input type="text" id="complemento" name="complemento" value="{{ $contact->complemento }}">
            </div>
            <div class="form-group">
                <label for="lista-enderecos">Possíveis Endereços:</label>
                <select id="lista-enderecos" onchange="preencherEndereco()">
                    <option value="">Selecione um endereço</option>
                </select>
            </div>
            <button type="submit" class="btn">Atualizar</button>
        </form>
    </div>

    <script>
        async function buscarEndereco() {
            const uf = document.getElementById('uf').value;
            const cidade = document.getElementById('cidade').value;
            const logradouro = document.getElementById('logradouro').value;

            if (uf && cidade && logradouro) {
                const response = await fetch(`/api/buscar-endereco?uf=${uf}&cidade=${cidade}&logradouro=${logradouro}`);
                const enderecos = await response.json();

                const listaEnderecos = document.getElementById('lista-enderecos');
                listaEnderecos.innerHTML = '<option value="">Selecione um endereço</option>';

                enderecos.forEach(endereco => {
                    const option = document.createElement('option');
                    option.value = `${endereco.logradouro}, ${endereco.bairro}, ${endereco.localidade} - ${endereco.uf}`;
                    option.textContent = `${endereco.logradouro}, ${endereco.bairro}, ${endereco.localidade} - ${endereco.uf}`;
                    listaEnderecos.appendChild(option);
                });
            }
        }

        async function buscarEnderecoPorCep() {
            const cep = document.getElementById('cep').value.replace(/\D/g, '');

            if (cep.length === 8) {
                const response = await fetch(`/api/buscar-endereco-por-cep?cep=${cep}`);
                const endereco = await response.json();

                if (endereco) {
                    document.getElementById('logradouro').value = endereco.logradouro;
                    document.getElementById('bairro').value = endereco.bairro;
                    document.getElementById('cidade').value = endereco.localidade;
                    document.getElementById('uf').value = endereco.uf;
                }
            }
        }

        function preencherEndereco() {
            const enderecoSelecionado = document.getElementById('lista-enderecos').value;
            if (enderecoSelecionado) {
                const [logradouro, bairro, localidadeUf] = enderecoSelecionado.split(', ');
                const [localidade, uf] = localidadeUf.split(' - ');

                document.getElementById('logradouro').value = logradouro;
                document.getElementById('bairro').value = bairro;
                document.getElementById('cidade').value = localidade;
                document.getElementById('uf').value = uf;
            }
        }

        function limparFormatacao(event) {
            event.target.value = event.target.value.replace(/\D/g, '');
        }
    </script>

    <style>
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .form-group input {
            width:  95%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group select {
            width:  98%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .alert {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
            margin-bottom: 20px;

        }

        .alert ul {
            margin: 0;
            padding: 0;
            list-style-type: none;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            width: 98%;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
@endsection
