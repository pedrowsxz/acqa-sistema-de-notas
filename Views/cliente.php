<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Cliente</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        form, table { max-width: 600px; margin: auto; }
        table { border-collapse: collapse; margin-top: 30px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Cadastro de Cliente</h2>

    <form id="clienteForm">
        <input type="hidden" name="id" id="id">
        <label>Nome: <input type="text" name="nome" id="nome" required></label><br><br>
        <label>Email: <input type="email" name="email" id="email"></label><br><br>
        <label>Telefone: <input type="text" name="telefone" id="telefone"></label><br><br>
        <label>Status:
            <select name="status" id="status">
                <option value="1">Ativo</option>
                <option value="0">Inativo</option>
            </select>
        </label><br><br>
        <button type="submit">Salvar</button>
        <button type="button" onclick="resetForm()">Limpar</button>
    </form>

    <h3>Lista de Clientes</h3>
    <table id="clientesTable">
        <thead>
            <tr>
                <th>ID</th><th>Nome</th><th>Email</th><th>Telefone</th><th>Status</th><th>Ações</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <script>
        const form = document.getElementById('clienteForm');
        const tableBody = document.querySelector('#clientesTable tbody');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            const isUpdate = formData.get('id');

            const url = isUpdate ? '/cliente/update' : '/cliente';

            await fetch(url, {
                method: 'POST',
                body: formData
            });

            resetForm();
            loadClientes();
        });

        function resetForm() {
            form.reset();
            document.getElementById('id').value = '';
        }

        async function loadClientes() {
            const res = await fetch('/clientes');
            const data = await res.json();
            tableBody.innerHTML = '';

            data.forEach(cliente => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${cliente.cliente}</td>
                    <td>${cliente.nome}</td>
                    <td>${cliente.email || ''}</td>
                    <td>${cliente.telefone || ''}</td>
                    <td>${cliente.status == 1 ? 'Ativo' : 'Inativo'}</td>
                    <td>
                        <button onclick='editCliente(${JSON.stringify(cliente)})'>Editar</button>
                        <button onclick='deleteCliente(${cliente.cliente})'>Excluir</button>
                    </td>
                `;
                tableBody.appendChild(tr);
            });
        }

        function editCliente(cliente) {
            document.getElementById('id').value = cliente.cliente;
            document.getElementById('nome').value = cliente.nome;
            document.getElementById('email').value = cliente.email || '';
            document.getElementById('telefone').value = cliente.telefone || '';
            document.getElementById('status').value = cliente.status;
        }

        async function deleteCliente(id) {
            const formData = new FormData();
            formData.append('id', id);

            await fetch('/cliente/delete', {
                method: 'POST',
                body: formData
            });

            loadClientes();
        }

        loadClientes();
    </script>
</body>
</html>
