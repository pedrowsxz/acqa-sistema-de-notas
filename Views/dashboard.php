<?php
session_start();
$userId = $_SESSION['user_id'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <style>table{border-collapse:collapse}th,td{border:1px solid #ccc;padding:6px}</style>
</head>
<body>
    <h2>Dashboard - Meus Eventos</h2>
    <p><a href="/logout">Sair</a></p>

    <h3>Adicionar / Editar Evento</h3>
    <form id="eventForm">
        <input type="hidden" name="id" id="id">
        <label>Título: <input type="text" name="title" id="title" required></label><br><br>
        <label>Descrição:<br><textarea name="description" id="description" rows="4" cols="50"></textarea></label><br><br>
        <label>Data: <input type="date" name="date" id="date"></label><br><br>
        <button type="submit">Salvar</button>
        <button type="button" onclick="resetForm()">Limpar</button>
    </form>

    <h3>Meus Eventos</h3>
    <table id="eventsTable">
        <thead><tr><th>ID</th><th>Título</th><th>Data</th><th>Ações</th></tr></thead>
        <tbody></tbody>
    </table>

    <script>
        const form = document.getElementById('eventForm');
        const tbody = document.querySelector('#eventsTable tbody');

        async function loadEvents(){
            const res = await fetch('/events');
            const data = await res.json();
            tbody.innerHTML = '';
            data.forEach(ev => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${ev.id}</td>
                    <td>${ev.title}</td>
                    <td>${ev.date || ''}</td>
                    <td>
                        <button onclick='editEvent(${JSON.stringify(ev)})'>Editar</button>
                        <button onclick='deleteEvent(${ev.id})'>Excluir</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const fd = new FormData(form);
            const isUpdate = fd.get('id');
            const url = isUpdate ? '/event/update' : '/event';
            await fetch(url, { method: 'POST', body: fd });
            resetForm(); loadEvents();
        });

        function resetForm(){ form.reset(); document.getElementById('id').value = ''; }

        function editEvent(ev){
            document.getElementById('id').value = ev.id;
            document.getElementById('title').value = ev.title;
            document.getElementById('description').value = ev.description || '';
            document.getElementById('date').value = ev.date || '';
        }

        async function deleteEvent(id){
            const fd = new FormData(); fd.append('id', id);
            await fetch('/event/delete', { method: 'POST', body: fd });
            loadEvents();
        }

        loadEvents();
    </script>
</body>
</html>
