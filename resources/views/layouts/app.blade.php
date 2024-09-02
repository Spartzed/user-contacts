<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Minha Aplicação')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <style>
        .navbar {
            overflow: hidden;
            background-color: #333;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .navbar .right {
            float: right;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    @include('components.navbar')

    <div style="margin-top: 50px;">
        @yield('content')

        <div id="deleteAccountModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Confirme a Exclusão da Conta</h2>
                <form id="confirm-delete-account-form" action="{{ route('account.delete') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <label for="password">Digite sua senha:</label>
                    <input type="password" id="password" name="password" required>
                    <button type="submit">Confirmar</button>
                </form>
            </div>
        </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = document.getElementById("deleteAccountModal");
            var btn = document.getElementById("delete-account-btn");
            var span = document.getElementsByClassName("close")[0];

            btn.onclick = function (event) {
                console.log('xxx', "????c");
                event.preventDefault();
                modal.style.display = "block";
            }

            span.onclick = function () {
                modal.style.display = "none";
            }

            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        });
    </script>
</body>
</html>
