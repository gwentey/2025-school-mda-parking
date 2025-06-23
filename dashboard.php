<?php
// ===== SIMULATION DES DONNÉES =====
// Pas de base de données - Utilisation d'un tableau PHP pour simuler les données

$parkingsData = [
    1 => [
        'id' => 1,
        'nom' => 'Parking Sorbonne',
        'adresse' => '17 Rue de la Sorbonne, 75005 Paris',
        'nbPlaces' => 20,
        'places' => [
            1 => ['numPlace' => 1, 'etat' => false], // false = libre, true = occupée
            2 => ['numPlace' => 2, 'etat' => true],
            3 => ['numPlace' => 3, 'etat' => false],
            4 => ['numPlace' => 4, 'etat' => true],
            5 => ['numPlace' => 5, 'etat' => false],
            6 => ['numPlace' => 6, 'etat' => true],
            7 => ['numPlace' => 7, 'etat' => false],
            8 => ['numPlace' => 8, 'etat' => false],
            9 => ['numPlace' => 9, 'etat' => true],
            10 => ['numPlace' => 10, 'etat' => false],
            11 => ['numPlace' => 11, 'etat' => true],
            12 => ['numPlace' => 12, 'etat' => false],
            13 => ['numPlace' => 13, 'etat' => true],
            14 => ['numPlace' => 14, 'etat' => false],
            15 => ['numPlace' => 15, 'etat' => false],
            16 => ['numPlace' => 16, 'etat' => true],
            17 => ['numPlace' => 17, 'etat' => false],
            18 => ['numPlace' => 18, 'etat' => true],
            19 => ['numPlace' => 19, 'etat' => false],
            20 => ['numPlace' => 20, 'etat' => false]
        ],
        'barriere' => [
            'id' => 1,
            'etat' => false, // false = fermée, true = ouverte
            'type' => 'entree'
        ]
    ],
    2 => [
        'id' => 2,
        'nom' => 'Parking Panthéon',
        'adresse' => 'Place du Panthéon, 75005 Paris',
        'nbPlaces' => 15,
        'places' => [
            1 => ['numPlace' => 1, 'etat' => true],
            2 => ['numPlace' => 2, 'etat' => false],
            3 => ['numPlace' => 3, 'etat' => true],
            4 => ['numPlace' => 4, 'etat' => false],
            5 => ['numPlace' => 5, 'etat' => true],
            6 => ['numPlace' => 6, 'etat' => false],
            7 => ['numPlace' => 7, 'etat' => true],
            8 => ['numPlace' => 8, 'etat' => false],
            9 => ['numPlace' => 9, 'etat' => false],
            10 => ['numPlace' => 10, 'etat' => true],
            11 => ['numPlace' => 11, 'etat' => false],
            12 => ['numPlace' => 12, 'etat' => true],
            13 => ['numPlace' => 13, 'etat' => false],
            14 => ['numPlace' => 14, 'etat' => false],
            15 => ['numPlace' => 15, 'etat' => true]
        ],
        'barriere' => [
            'id' => 2,
            'etat' => true,
            'type' => 'entree'
        ]
    ],
    3 => [
        'id' => 3,
        'nom' => 'Parking Châtelet',
        'adresse' => '1 Place du Châtelet, 75001 Paris',
        'nbPlaces' => 25,
        'places' => [
            1 => ['numPlace' => 1, 'etat' => false],
            2 => ['numPlace' => 2, 'etat' => false],
            3 => ['numPlace' => 3, 'etat' => true],
            4 => ['numPlace' => 4, 'etat' => false],
            5 => ['numPlace' => 5, 'etat' => true],
            6 => ['numPlace' => 6, 'etat' => false],
            7 => ['numPlace' => 7, 'etat' => true],
            8 => ['numPlace' => 8, 'etat' => false],
            9 => ['numPlace' => 9, 'etat' => false],
            10 => ['numPlace' => 10, 'etat' => true],
            11 => ['numPlace' => 11, 'etat' => false],
            12 => ['numPlace' => 12, 'etat' => false],
            13 => ['numPlace' => 13, 'etat' => true],
            14 => ['numPlace' => 14, 'etat' => false],
            15 => ['numPlace' => 15, 'etat' => true],
            16 => ['numPlace' => 16, 'etat' => false],
            17 => ['numPlace' => 17, 'etat' => false],
            18 => ['numPlace' => 18, 'etat' => true],
            19 => ['numPlace' => 19, 'etat' => false],
            20 => ['numPlace' => 20, 'etat' => true],
            21 => ['numPlace' => 21, 'etat' => false],
            22 => ['numPlace' => 22, 'etat' => false],
            23 => ['numPlace' => 23, 'etat' => true],
            24 => ['numPlace' => 24, 'etat' => false],
            25 => ['numPlace' => 25, 'etat' => false]
        ],
        'barriere' => [
            'id' => 3,
            'etat' => false,
            'type' => 'entree'
        ]
    ]
];

// Gestion des requêtes AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (isset($input['action'])) {
        switch ($input['action']) {
            case 'set_barrier_state':
                $parkingId = $input['parkingId'];
                $newState = $input['state']; // true = ouverte, false = fermée
                if (isset($parkingsData[$parkingId])) {
                    $parkingsData[$parkingId]['barriere']['etat'] = $newState;
                    echo json_encode([
                        'success' => true,
                        'barriere_etat' => $parkingsData[$parkingId]['barriere']['etat']
                    ]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Parking non trouvé']);
                }
                break;
                
            case 'get_parking_data':
                $parkingId = $input['parkingId'];
                if (isset($parkingsData[$parkingId])) {
                    $parking = $parkingsData[$parkingId];
                    $placesLibres = count(array_filter($parking['places'], function($place) {
                        return !$place['etat'];
                    }));
                    
                    echo json_encode([
                        'success' => true,
                        'parking' => $parking,
                        'placesLibres' => $placesLibres
                    ]);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Parking non trouvé']);
                }
                break;
                
            default:
                echo json_encode(['success' => false, 'error' => 'Action non reconnue']);
        }
    }
    exit;
}

// Fonction pour calculer les places libres
function getPlacesLibres($places) {
    return count(array_filter($places, function($place) {
        return !$place['etat'];
    }));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Parking - Master MIAGE</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Animation pour la barrière */
        .barrier {
            transition: transform 0.5s ease-in-out;
        }
        
        .barrier.open {
            transform: rotate(90deg);
        }
        
        .barrier.closed {
            transform: rotate(0deg);
        }
        
        /* Boutons personnalisés avec dégradés */
        .btn-custom-open {
            background: linear-gradient(135deg, #10b981, #059669);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }
        
        .btn-custom-open:hover {
            background: linear-gradient(135deg, #059669, #047857);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            transform: translateY(-2px);
        }
        
        .btn-custom-close {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }
        
        .btn-custom-close:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
            transform: translateY(-2px);
        }
        
        /* Places de parking */
        .parking-spot {
            width: 60px;
            height: 40px;
            border-radius: 8px;
            border: 2px solid #374151;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 12px;
            transition: all 0.3s ease;
        }
        
        .parking-spot.libre {
            background-color: #10b981;
            color: white;
            border-color: #059669;
        }
        
        .parking-spot.occupee {
            background-color: #ef4444;
            color: white;
            border-color: #dc2626;
        }
        
        /* Widgets dashboard */
        .dashboard-widget {
            background: rgba(31, 41, 55, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(55, 65, 81, 0.3);
        }
        
        /* Animation de pulse pour les statistiques */
        .stats-pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        
        /* Responsive grid pour les places */
        .parking-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(60px, 1fr));
            gap: 10px;
            max-width: 100%;
        }
        
        /* Effet de survol sur les widgets */
        .dashboard-widget:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }
        
        /* Styles pour le widget incidents */
        .voice-wave {
            display: flex;
            align-items: center;
            gap: 2px;
        }
        
        .wave-bar {
            width: 3px;
            background: linear-gradient(to top, #10b981, #34d399);
            border-radius: 2px;
            animation: wave 1.5s infinite ease-in-out;
        }
        
        .wave-bar:nth-child(1) { animation-delay: 0s; }
        .wave-bar:nth-child(2) { animation-delay: 0.1s; }
        .wave-bar:nth-child(3) { animation-delay: 0.2s; }
        .wave-bar:nth-child(4) { animation-delay: 0.3s; }
        .wave-bar:nth-child(5) { animation-delay: 0.4s; }
        .wave-bar:nth-child(6) { animation-delay: 0.5s; }
        .wave-bar:nth-child(7) { animation-delay: 0.6s; }
        .wave-bar:nth-child(8) { animation-delay: 0.7s; }
        
        @keyframes wave {
            0%, 100% { height: 4px; }
            50% { height: 20px; }
        }
        
        .license-plate {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            border: 3px solid #1e293b;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-weight: bold;
            letter-spacing: 2px;
            position: relative;
            overflow: hidden;
        }
        
        .license-plate::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
            animation: shine 3s infinite;
        }
        
        @keyframes shine {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        .communication-indicator {
            background: linear-gradient(135deg, #059669, #10b981);
            animation: pulse-green 2s infinite;
        }
        
        @keyframes pulse-green {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }
        
        /* Scrollbar moderne personnalisée */
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #4b5563 #1f2937;
        }
        
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #1f2937;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #4b5563, #6b7280);
            border-radius: 10px;
            border: 1px solid #374151;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #6b7280, #9ca3af);
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:active {
            background: linear-gradient(135deg, #9ca3af, #d1d5db);
        }
        
        /* Animation de la scrollbar au survol du conteneur */
        .custom-scrollbar:hover::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #10b981, #059669);
        }
    </style>
</head>
<body class="bg-gray-900 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">Dashboard Parking</h1>
            <p class="text-gray-400">Système de supervision - Master MIAGE</p>
            <div class="mt-4 text-sm text-gray-500">
                <p>Équipe : Anthony Rodrigues • Aurelie Loriot • Fabien Rondan • Paul Adnet</p>
            </div>
        </div>
        
        <!-- Layout responsive -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 max-w-7xl mx-auto">
            
            <!-- Widget Panneau de Contrôle -->
            <div class="dashboard-widget rounded-xl shadow-2xl p-6 transition-all duration-300">
                <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                    <!-- Icône de contrôle -->
                    <svg class="w-8 h-8 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                    </svg>
                    Panneau de Contrôle
                </h2>
                
                <!-- Sélecteur de parking -->
                <div class="mb-6">
                    <label class="block text-gray-300 text-sm font-medium mb-2">Sélectionner un parking :</label>
                    <select id="parkingSelector" class="w-full bg-gray-800 border border-gray-600 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
                        <?php foreach ($parkingsData as $parking): ?>
                            <option value="<?= $parking['id'] ?>" <?= $parking['id'] == 1 ? 'selected' : '' ?>>
                                <?= htmlspecialchars($parking['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- Contrôles de la barrière -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-white mb-4">Contrôle de la Barrière</h3>
                    <div class="flex space-x-4">
                        <button id="openBarrier" class="btn-custom-open flex-1 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                            </svg>
                            Ouvrir
                        </button>
                        <button id="closeBarrier" class="btn-custom-close flex-1 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Fermer
                        </button>
                    </div>
                </div>
                
                <!-- Visualisation de la barrière -->
                <div class="bg-gray-800 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-white mb-4 text-center">État de la Barrière</h3>
                    <div class="flex flex-col items-center">
                        <div class="relative w-32 h-32 mb-4">
                            <!-- Base de la barrière -->
                            <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-4 h-16 bg-gray-600 rounded"></div>
                            <!-- Bras de la barrière -->
                            <div id="barrierArm" class="barrier absolute bottom-16 left-1/2 transform -translate-x-1/2 w-20 h-2 bg-red-500 rounded origin-left"></div>
                            <!-- Indicateur d'état -->
                            <div id="barrierIndicator" class="absolute top-0 left-1/2 transform -translate-x-1/2 w-4 h-4 rounded-full bg-red-500"></div>
                        </div>
                        <span id="barrierStatus" class="text-lg font-medium text-red-400">Fermée</span>
                    </div>
                </div>
            </div>
            
            <!-- Widget Visualisation du Parking -->
            <div class="dashboard-widget rounded-xl shadow-2xl p-6 transition-all duration-300">
                <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                    <!-- Icône de parking -->
                    <svg class="w-8 h-8 mr-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <span id="parkingName">Parking Sorbonne</span>
                </h2>
                
                <!-- Statistiques -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-800 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-green-400 stats-pulse" id="placesLibres">0</div>
                        <div class="text-sm text-gray-400">Places Libres</div>
                    </div>
                    <div class="bg-gray-800 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-blue-400" id="totalPlaces">0</div>
                        <div class="text-sm text-gray-400">Total Places</div>
                    </div>
                </div>
                
                <!-- Adresse du parking -->
                <div class="mb-6 p-3 bg-gray-800 rounded-lg">
                    <div class="text-sm text-gray-400">Adresse :</div>
                    <div class="text-white" id="parkingAddress">17 Rue de la Sorbonne, 75005 Paris</div>
                </div>
                
                <!-- Grille des places -->
                <div class="bg-gray-800 rounded-lg p-4">
                    <h3 class="text-lg font-medium text-white mb-4 text-center">Plan du Parking</h3>
                    <div id="parkingGrid" class="parking-grid">
                        <!-- Les places seront générées dynamiquement par JavaScript -->
                    </div>
                </div>
                
                <!-- Légende -->
                <div class="flex justify-center space-x-6 mt-4">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-green-500 rounded mr-2"></div>
                        <span class="text-sm text-gray-300">Libre</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-red-500 rounded mr-2"></div>
                        <span class="text-sm text-gray-300">Occupée</span>
                    </div>
                </div>
            </div>
            
            <!-- Widget Gestion des Incidents -->
            <div class="dashboard-widget rounded-xl shadow-2xl p-6 transition-all duration-300">
                <h2 class="text-2xl font-semibold text-white mb-6 flex items-center">
                    <!-- Icône d'incident -->
                    <svg class="w-8 h-8 mr-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    Gestion des Incidents
                </h2>
                
                <!-- État de communication -->
                <div class="mb-6 p-3 bg-gray-800 rounded-lg border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="communication-indicator w-3 h-3 rounded-full mr-2"></div>
                            <span class="text-green-400 font-medium text-sm">COMM. ACTIVE</span>
                            <span class="text-xs text-gray-400 ml-3" id="communicationTimer">
                                <span id="timerDisplay">1m 14s</span>
                            </span>
                            
                            <!-- Visualiseur audio -->
                            <svg class="w-4 h-4 text-green-400 ml-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                            </svg>
                            <div class="voice-wave">
                                <div class="wave-bar"></div>
                                <div class="wave-bar"></div>
                                <div class="wave-bar"></div>
                                <div class="wave-bar"></div>
                                <div class="wave-bar"></div>
                                <div class="wave-bar"></div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500">🔊 Audio</div>
                    </div>
                </div>
                
                <!-- Informations du conducteur -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-white mb-4">Conducteur en ligne</h3>
                    <div class="bg-gray-800 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <div class="text-sm text-gray-400">Immatriculation</div>
                                <div class="license-plate text-white px-4 py-2 text-lg mt-2 inline-block" id="licensePlate">
                                    AB-123-CD
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-400">Parking</div>
                                <div class="text-white font-medium" id="incidentParking">Parking Sorbonne</div>
                            </div>
                        </div>
                        
                        <!-- Type d'incident -->
                        <div class="mb-4">
                            <div class="text-sm text-gray-400 mb-2">Type d'incident signalé</div>
                            <div class="flex flex-wrap gap-2">
                                <span class="px-3 py-1 bg-red-600 text-white text-sm rounded-full">Barrière bloquée</span>
                                <span class="px-3 py-1 bg-orange-600 text-white text-sm rounded-full">Paiement impossible</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Transcription en temps réel -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-white mb-3">Transcription en temps réel</h3>
                    <div class="bg-gray-800 rounded-lg p-4 h-32 overflow-y-auto custom-scrollbar">
                        <div class="space-y-2 text-sm" id="transcription">
                            <div class="text-blue-300">
                                <span class="text-gray-500">[1m 14s]</span> Conducteur: "Bonjour, j'ai un problème avec la barrière..."
                            </div>
                            <div class="text-green-300">
                                <span class="text-gray-500">[1m 18s]</span> Opérateur: "Bonjour, pouvez-vous me donner votre immatriculation ?"
                            </div>
                            <div class="text-blue-300">
                                <span class="text-gray-500">[1m 22s]</span> Conducteur: "AB-123-CD, la barrière ne s'ouvre pas..."
                            </div>
                            <div class="text-green-300 opacity-50">
                                <span class="text-gray-500">[En cours...]</span> Opérateur: "Je vais vérifier le système..."
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="space-y-3">
                    <button id="createIncidentBtn" class="w-full bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 hover:from-red-700 hover:to-red-800 hover:shadow-lg hover:shadow-red-500/25 transform hover:-translate-y-1">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Créer l'Incident
                    </button>
                    
                    <div class="flex space-x-3">
                        <button class="flex-1 bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors hover:bg-gray-600">
                            Résoudre
                        </button>
                        <button class="flex-1 bg-yellow-600 text-white font-medium py-2 px-4 rounded-lg transition-colors hover:bg-yellow-700">
                            Transférer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Variables globales
        let currentParkingId = 1;
        let parkingsData = <?= json_encode($parkingsData) ?>;
        let communicationStartTime = Date.now() - 74000; // Démarré il y a 1m 14s
        let incidentTimer;
        
        // Éléments DOM
        const parkingSelector = document.getElementById('parkingSelector');
        const openBarrierBtn = document.getElementById('openBarrier');
        const closeBarrierBtn = document.getElementById('closeBarrier');
        const barrierArm = document.getElementById('barrierArm');
        const barrierIndicator = document.getElementById('barrierIndicator');
        const barrierStatus = document.getElementById('barrierStatus');
        const parkingName = document.getElementById('parkingName');
        const parkingAddress = document.getElementById('parkingAddress');
        const placesLibres = document.getElementById('placesLibres');
        const totalPlaces = document.getElementById('totalPlaces');
        const parkingGrid = document.getElementById('parkingGrid');
        const timerDisplay = document.getElementById('timerDisplay');
        const createIncidentBtn = document.getElementById('createIncidentBtn');
        const transcription = document.getElementById('transcription');
        
        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            updateParkingDisplay();
            updateBarrierDisplay();
            startIncidentTimer();
            simulateIncidentConversation();
        });
        
        // Gestionnaire de changement de parking
        parkingSelector.addEventListener('change', function() {
            currentParkingId = parseInt(this.value);
            updateParkingDisplay();
            updateBarrierDisplay();
        });
        
        // Gestionnaires des boutons de barrière
        openBarrierBtn.addEventListener('click', function() {
            setBarrierState(true);
        });
        
        closeBarrierBtn.addEventListener('click', function() {
            setBarrierState(false);
        });
        
        // Gestionnaire du bouton créer incident
        createIncidentBtn.addEventListener('click', function() {
            createIncident();
        });
        
        // Fonction pour définir l'état de la barrière
        function setBarrierState(desiredState) {
            const currentState = parkingsData[currentParkingId].barriere.etat;
            
            // Ne rien faire si l'état est déjà le bon
            if (currentState === desiredState) {
                return;
            }
            
            // Désactiver les boutons pendant la requête
            openBarrierBtn.disabled = true;
            closeBarrierBtn.disabled = true;
            openBarrierBtn.style.opacity = '0.6';
            closeBarrierBtn.style.opacity = '0.6';
            
            fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'set_barrier_state',
                    parkingId: currentParkingId,
                    state: desiredState
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    parkingsData[currentParkingId].barriere.etat = data.barriere_etat;
                    updateBarrierDisplay();
                } else {
                    console.error('Erreur:', data.error);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            })
            .finally(() => {
                // Réactiver les boutons
                openBarrierBtn.disabled = false;
                closeBarrierBtn.disabled = false;
                openBarrierBtn.style.opacity = '1';
                closeBarrierBtn.style.opacity = '1';
            });
        }
        
        // Fonction pour mettre à jour l'affichage de la barrière
        function updateBarrierDisplay() {
            const isOpen = parkingsData[currentParkingId].barriere.etat;
            
            if (isOpen) {
                barrierArm.classList.remove('closed');
                barrierArm.classList.add('open');
                barrierIndicator.classList.remove('bg-red-500');
                barrierIndicator.classList.add('bg-green-500');
                barrierStatus.textContent = 'Ouverte';
                barrierStatus.classList.remove('text-red-400');
                barrierStatus.classList.add('text-green-400');
                
                // Désactiver le bouton "Ouvrir" et activer "Fermer"
                openBarrierBtn.style.opacity = '0.5';
                openBarrierBtn.style.cursor = 'not-allowed';
                closeBarrierBtn.style.opacity = '1';
                closeBarrierBtn.style.cursor = 'pointer';
            } else {
                barrierArm.classList.remove('open');
                barrierArm.classList.add('closed');
                barrierIndicator.classList.remove('bg-green-500');
                barrierIndicator.classList.add('bg-red-500');
                barrierStatus.textContent = 'Fermée';
                barrierStatus.classList.remove('text-green-400');
                barrierStatus.classList.add('text-red-400');
                
                // Activer le bouton "Ouvrir" et désactiver "Fermer"
                openBarrierBtn.style.opacity = '1';
                openBarrierBtn.style.cursor = 'pointer';
                closeBarrierBtn.style.opacity = '0.5';
                closeBarrierBtn.style.cursor = 'not-allowed';
            }
        }
        
        // Fonction pour mettre à jour l'affichage du parking
        function updateParkingDisplay() {
            const parking = parkingsData[currentParkingId];
            
            // Mettre à jour les informations du parking
            parkingName.textContent = parking.nom;
            parkingAddress.textContent = parking.adresse;
            totalPlaces.textContent = parking.nbPlaces;
            
            // Calculer les places libres
            const libres = Object.values(parking.places).filter(place => !place.etat).length;
            placesLibres.textContent = libres;
            
            // Générer la grille des places
            generateParkingGrid(parking.places);
        }
        
        // Fonction pour générer la grille des places
        function generateParkingGrid(places) {
            parkingGrid.innerHTML = '';
            
            Object.values(places).forEach(place => {
                const placeElement = document.createElement('div');
                placeElement.className = `parking-spot ${place.etat ? 'occupee' : 'libre'}`;
                placeElement.textContent = place.numPlace;
                placeElement.title = `Place ${place.numPlace} - ${place.etat ? 'Occupée' : 'Libre'}`;
                
                // Ajouter un effet de clic pour simuler le changement d'état
                placeElement.addEventListener('click', function() {
                    // Simulation du changement d'état (pour la démo)
                    place.etat = !place.etat;
                    updateParkingDisplay();
                });
                
                parkingGrid.appendChild(placeElement);
            });
        }
        
        // ===== FONCTIONS POUR LA GESTION DES INCIDENTS =====
        
        // Fonction pour démarrer le timer de communication
        function startIncidentTimer() {
            incidentTimer = setInterval(function() {
                const now = Date.now();
                const elapsed = now - communicationStartTime;
                const minutes = Math.floor(elapsed / 60000);
                const seconds = Math.floor((elapsed % 60000) / 1000);
                timerDisplay.textContent = `${minutes}m ${seconds}s`;
            }, 1000);
        }
        
        // Fonction pour simuler une conversation d'incident
        function simulateIncidentConversation() {
            const conversations = [
                { speaker: 'Opérateur', message: 'Je vérifie votre dossier...', delay: 8000 },
                { speaker: 'Conducteur', message: 'Merci, je patiente.', delay: 15000 },
                { speaker: 'Opérateur', message: 'Je vois le problème, votre ticket a expiré.', delay: 22000 },
                { speaker: 'Conducteur', message: 'Comment ça se fait ? J\'étais dans les temps !', delay: 28000 },
                { speaker: 'Opérateur', message: 'Pas de problème, je vais débloquer la situation.', delay: 35000 }
            ];
            
            conversations.forEach((conv, index) => {
                setTimeout(() => {
                    addMessageToTranscription(conv.speaker, conv.message);
                }, conv.delay);
            });
        }
        
        // Fonction pour ajouter un message à la transcription
        function addMessageToTranscription(speaker, message) {
            const now = Date.now();
            const elapsed = now - communicationStartTime;
            const minutes = Math.floor(elapsed / 60000);
            const seconds = Math.floor((elapsed % 60000) / 1000);
            const timeStamp = `${minutes}m ${seconds}s`;
            
            const messageDiv = document.createElement('div');
            const colorClass = speaker === 'Conducteur' ? 'text-blue-300' : 'text-green-300';
            messageDiv.className = colorClass;
            messageDiv.innerHTML = `<span class="text-gray-500">[${timeStamp}]</span> ${speaker}: "${message}"`;
            
            // Supprimer le message "En cours..."
            const inProgressMsg = transcription.querySelector('.opacity-50');
            if (inProgressMsg) {
                inProgressMsg.remove();
            }
            
            transcription.appendChild(messageDiv);
            
            // Ajouter un nouveau message "En cours..." si ce n'est pas le dernier
            const newInProgressDiv = document.createElement('div');
            newInProgressDiv.className = 'text-green-300 opacity-50';
            newInProgressDiv.innerHTML = '<span class="text-gray-500">[En cours...]</span> Opérateur: "..."';
            transcription.appendChild(newInProgressDiv);
            
            // Faire défiler vers le bas
            transcription.scrollTop = transcription.scrollHeight;
        }
        
        // Fonction pour créer un incident
        function createIncident() {
            // Animation du bouton
            createIncidentBtn.style.transform = 'scale(0.95)';
            createIncidentBtn.innerHTML = '⏳ Création en cours...';
            
            setTimeout(() => {
                createIncidentBtn.style.transform = 'scale(1)';
                createIncidentBtn.innerHTML = `
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Incident Créé !
                `;
                createIncidentBtn.className = createIncidentBtn.className.replace('from-red-600 to-red-700', 'from-green-600 to-green-700');
                
                // Afficher une notification
                showIncidentNotification();
                
                // Réinitialiser après 3 secondes
                setTimeout(() => {
                    resetIncidentButton();
                }, 3000);
            }, 2000);
        }
        
        // Fonction pour afficher une notification d'incident
        function showIncidentNotification() {
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-600 text-white p-4 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
            notification.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <div class="font-semibold">Incident créé avec succès !</div>
                        <div class="text-sm opacity-90">ID: INC-${Date.now().toString().slice(-6)}</div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Animation d'entrée
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);
            
            // Animation de sortie
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 4000);
        }
        
        // Fonction pour réinitialiser le bouton d'incident
        function resetIncidentButton() {
            createIncidentBtn.innerHTML = `
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Créer l'Incident
            `;
            createIncidentBtn.className = createIncidentBtn.className.replace('from-green-600 to-green-700', 'from-red-600 to-red-700');
        }
        
        // Génération aléatoire d'immatriculations pour la démo
        function generateRandomLicensePlate() {
            const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            const numbers = '0123456789';
            const plate = 
                letters[Math.floor(Math.random() * letters.length)] +
                letters[Math.floor(Math.random() * letters.length)] +
                '-' +
                numbers[Math.floor(Math.random() * numbers.length)] +
                numbers[Math.floor(Math.random() * numbers.length)] +
                numbers[Math.floor(Math.random() * numbers.length)] +
                '-' +
                letters[Math.floor(Math.random() * letters.length)] +
                letters[Math.floor(Math.random() * letters.length)];
            
            document.getElementById('licensePlate').textContent = plate;
        }
        
        // Changer l'immatriculation toutes les 30 secondes pour la démo
        setInterval(generateRandomLicensePlate, 30000);
        
        // Simulation de mise à jour en temps réel (optionnel)
        setInterval(function() {
            // Ici on pourrait ajouter une simulation de changement aléatoire d'état des places
            // Pour la démo, on peut laisser vide ou ajouter une petite animation
        }, 5000);
    </script>
</body>
</html> 