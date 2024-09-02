@extends('layouts.app')

@section('title', 'Criar Contato')

@section('content')
    <h2>Cadastro de Contatos</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('contacts.store') }}">
        @csrf
        <div>
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        <div>
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" oninput="limparFormatacao(event)" value="{{ old('cpf') }}" required>
        </div>
        <div>
            <label for="phone">Telefone:</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required>
        </div>
        <div>
            <label for="cep">CEP:</label>
            <input type="text" id="cep" name="cep" value="{{ old('cep') }}" oninput="limparFormatacao(event); buscarEnderecoPorCep()" required>
        </div>
        <div>
            <label for="uf">UF:</label>
            <input type="text" id="uf" name="uf" oninput="buscarEndereco()" value="{{ old('uf') }}" required>
        </div>
        <div>
            <label for="cidade">Cidade:</label>
            <input type="text" id="cidade" name="cidade" oninput="buscarEndereco()" value="{{ old('cidade') }}" required>
        </div>
        <div>
            <label for="bairro">Bairro:</label>
            <input type="text" id="bairro" name="bairro" value="{{ old('bairro') }}" required>
        </div>
        <div>
            <label for="logradouro">Logradouro:</label>
            <input type="text" id="logradouro" name="logradouro" value="{{ old('logradouro') }}" oninput="buscarEndereco()" required>
        </div>
        <div>
            <label for="numero">Número:</label>
            <input type="text" id="numero" name="numero" value="{{ old('numero') }}" required>
        </div>
        <div>
            <label for="complemento">Complemento:</label>
            <input type="text" id="complemento" value="{{ old('complemento') }}" name="complemento">
        </div>
        <div>
            <label for="lista-enderecos">Possíveis Endereços:</label>
            <select id="lista-enderecos" onchange="preencherEndereco()">
                <option value="">Selecione um endereço</option>
            </select>
        </div>
        <button type="submit">Cadastrar</button>
    </form>

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
@endsection