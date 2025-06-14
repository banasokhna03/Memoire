<?php
$statusLabels = [
    'pending' => 'En attente',
    'accepted' => 'Acceptée',
    'rejected' => 'Refusée'
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestion des candidatures</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            padding: 3px 6px;
            border-radius: 3px;
        }
        .status-accepted {
            background-color: #d4edda;
            color: #155724;
            padding: 3px 6px;
            border-radius: 3px;
        }
        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
            padding: 3px 6px;
            border-radius: 3px;
        }
        .btn {
            display: inline-block;
            padding: 5px 10px;
            margin: 2px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
        }
        .empty-message {
            text-align: center;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>Candidatures</h1>
    <p>Gérez toutes les candidatures reçues pour vos offres d'emploi</p>

    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <strong>{{ $applications->total() }} candidature(s)</strong>
            @if(request('status'))
                <span style="margin-left: 10px; background-color: #cce5ff; color: #004085; font-size: 12px; padding: 3px 8px; border-radius: 10px;">Filtrées</span>
                <a href="{{ route('admin.applications.index') }}" style="color: #007bff; margin-left: 10px;">Réinitialiser</a>
            @endif
        </div>
        
        <div>
            <form method="GET" action="{{ route('admin.applications.index') }}">
                <select name="status" onchange="this.form.submit()" style="border: 1px solid #ced4da; border-radius: 4px; padding: 5px;">
                    <option value="">Tous les statuts</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Acceptées</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Refusées</option>
                </select>
            </form>
        </div>
    </div>

    @if($applications->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Candidat</th>
                    <th>Offre</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>CV</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $application)
                    <tr>
                        <td>{{ $application->user ? $application->user->name : 'Utilisateur supprimé' }}</td>
                        <td>{{ $application->offer ? $application->offer->title : 'N/A' }}</td>
                        <td>{{ $application->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($application->status == 'pending')
                                <span class="status-pending">En attente</span>
                            @elseif($application->status == 'accepted')
                                <span class="status-accepted">Acceptée</span>
                            @elseif($application->status == 'rejected')
                                <span class="status-rejected">Refusée</span>
                            @endif
                        </td>
                        <td>
                            @if($application->cv_path)
                                <a href="{{ route('admin.applications.download-cv', $application->id) }}" class="btn" target="_blank">
                                    Télécharger
                                </a>
                            @else
                                <span>Aucun CV</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.applications.show', $application->id) }}" class="btn">Détails</a>
                            <form method="POST" action="{{ route('admin.applications.update-status', $application->id) }}" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="pending">
                                <button type="submit" class="btn">En attente</button>
                            </form>
                            <form method="POST" action="{{ route('admin.applications.update-status', $application->id) }}" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="accepted">
                                <button type="submit" class="btn">Accepter</button>
                            </form>
                            <form method="POST" action="{{ route('admin.applications.update-status', $application->id) }}" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="btn">Refuser</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $applications->links() }}
    @else
        <div class="empty-message">
            <p>Aucune candidature n'a été trouvée.</p>
        </div>
    @endif
</body>
</html>
