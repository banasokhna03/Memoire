<?php
$statusStyles = [
    'pending' => 'background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba;',
    'accepted' => 'background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb;',
    'rejected' => 'background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;'
];

$statusLabels = [
    'pending' => 'En attente',
    'accepted' => 'Acceptée',
    'rejected' => 'Refusée'
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Détails de la candidature</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
            color: #333;
        }
        h1, h2, h3 {
            color: #333;
            margin-bottom: 10px;
        }
        a {
            color: #3490dc;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }
        .header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .content {
            padding: 20px;
        }
        .section {
            margin-bottom: 25px;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            padding: 15px;
            background-color: #fff;
        }
        .section-title {
            font-size: 18px;
            margin-bottom: 15px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 14px;
            font-weight: bold;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 15px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .info-label {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 3px;
        }
        .btn {
            display: inline-block;
            padding: 8px 15px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            text-decoration: none;
            color: #333;
            cursor: pointer;
        }
        .btn-primary {
            background-color: #3490dc;
            border-color: #3490dc;
            color: white;
        }
        .btn-primary:hover {
            background-color: #2779bd;
        }
        .status-dropdown {
            position: relative;
            display: inline-block;
        }
        .status-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            min-width: 200px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            z-index: 10;
        }
        .status-form {
            display: block;
            padding: 8px 15px;
        }
        .status-form button {
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            padding: 8px;
            font-size: 14px;
        }
        .status-pending button:hover {
            background-color: #fff3cd;
        }
        .status-accepted button:hover {
            background-color: #d4edda;
        }
        .status-rejected button:hover {
            background-color: #f8d7da;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>Détails de la candidature</h1>
                <p>Soumise le {{ $application->created_at->format('d/m/Y à H:i') }}</p>
            </div>
            <a href="{{ route('admin.applications.index') }}" class="btn">Retour à la liste</a>
        </div>

        <div class="content">
            <!-- Statut -->
            <div class="section">
                <h3 class="section-title">Statut de la candidature</h3>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span class="status-badge" style="{{ $statusStyles[$application->status] }}">
                        {{ $statusLabels[$application->status] }}
                    </span>
                    
                    <div class="status-dropdown">
                        <button class="btn btn-primary" onclick="toggleStatusMenu()">
                            Modifier le statut
                        </button>
                        <div id="statusDropdown" class="status-dropdown-content">
                            <form class="status-form status-pending" method="POST" action="{{ route('admin.applications.update-status', $application->id) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="pending">
                                <button type="submit">Marquer comme En attente</button>
                            </form>
                            <form class="status-form status-accepted" method="POST" action="{{ route('admin.applications.update-status', $application->id) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="accepted">
                                <button type="submit">Marquer comme Acceptée</button>
                            </form>
                            <form class="status-form status-rejected" method="POST" action="{{ route('admin.applications.update-status', $application->id) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit">Marquer comme Refusée</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Informations sur le candidat -->
            <div class="section">
                <h3 class="section-title">Informations sur le candidat</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Nom</div>
                        <div>{{ $application->user ? $application->user->name : 'Utilisateur supprimé' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div>{{ $application->user ? $application->user->email : 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Téléphone</div>
                        <div>{{ $application->phone ?? 'Non spécifié' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">CV</div>
                        <div>
                            @if($application->cv_path)
                                <a href="{{ route('admin.applications.download-cv', $application->id) }}">
                                    Télécharger le CV
                                </a>
                            @else
                                <span style="color: #6c757d;">Aucun CV fourni</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Offre concernée -->
            <div class="section">
                <h3 class="section-title">Offre concernée</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Titre de l'offre</div>
                        <div><strong>{{ $application->offer->title ?? 'N/A' }}</strong></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Entreprise</div>
                        <div>{{ $application->offer->company_name ?? 'N/A' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Date limite de l'offre</div>
                        <div>{{ $application->offer->deadline ? \Carbon\Carbon::parse($application->offer->deadline)->format('d/m/Y') : 'Non spécifiée' }}</div>
                    </div>
                </div>
                @if($application->offer)
                    <div style="margin-top: 10px;">
                        <a href="{{ route('offers.show', $application->offer->id) }}" target="_blank">
                            Voir l'offre complète
                        </a>
                    </div>
                @endif
            </div>
            
            <!-- Lettre de motivation -->
            <div class="section">
                <h3 class="section-title">Lettre de motivation</h3>
                <div style="white-space: pre-wrap;">{{ $application->cover_letter }}</div>
            </div>
        </div>
    </div>

    <script>
        function toggleStatusMenu() {
            var dropdown = document.getElementById("statusDropdown");
            if (dropdown.style.display === "block") {
                dropdown.style.display = "none";
            } else {
                dropdown.style.display = "block";
            }
        }
        
        // Fermer le menu si l'utilisateur clique en dehors
        window.onclick = function(event) {
            if (!event.target.matches('.btn-primary')) {
                var dropdowns = document.getElementsByClassName("status-dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.style.display === "block") {
                        openDropdown.style.display = "none";
                    }
                }
            }
        }
    </script>
</body>
</html>
