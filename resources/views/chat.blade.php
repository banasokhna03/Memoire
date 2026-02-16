<!DOCTYPE html>
<html>
<head>
    <title>Mon Chatbot </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
        
        * {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html, body {
            height: 100%;
            width: 100%;
        }
        
        body {
            background: linear-gradient(135deg, #2e1a47 0%, #1a1035 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        
        /* Particules flottantes */
        .floating-particle {
            position: absolute;
            width: 6px;
            height: 6px;
            background: rgba(200, 168, 255, 0.3);
            border-radius: 50%;
            pointer-events: none;
            animation: float 8s infinite ease-in-out;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0); opacity: 0.3; }
            50% { transform: translateY(-30px) translateX(20px); opacity: 0.8; }
        }
        
        /* Cristal principal - parfaitement centré */
        .crystal-main {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(200, 168, 255, 0.2) 100%);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 
                0 20px 50px rgba(138, 43, 226, 0.3),
                inset 0 0 30px rgba(255, 255, 255, 0.3);
            position: relative;
            transition: all 0.5s ease;
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
        }
        
        .crystal-main:hover {
            box-shadow: 
                0 25px 60px rgba(168, 85, 247, 0.4),
                inset 0 0 40px rgba(255, 255, 255, 0.4);
            transform: scale(1.01);
        }
        
        /* Effet de prisme */
        .prism-effect {
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(
                from 90deg at 50% 50%,
                rgba(255, 255, 255, 0) 0deg,
                rgba(200, 168, 255, 0.2) 60deg,
                rgba(255, 255, 255, 0.4) 120deg,
                rgba(168, 85, 247, 0.2) 180deg,
                rgba(255, 255, 255, 0) 240deg
            );
            animation: prismRotate 10s linear infinite;
            pointer-events: none;
            mix-blend-mode: overlay;
        }
        
        @keyframes prismRotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        /* Facettes de cristal */
        .crystal-facet {
            position: absolute;
            background: linear-gradient(135deg, 
                rgba(255, 255, 255, 0.3) 0%,
                rgba(200, 168, 255, 0.1) 50%,
                rgba(255, 255, 255, 0.3) 100%
            );
            filter: blur(5px);
            animation: facetGlow 4s infinite alternate;
        }
        
        @keyframes facetGlow {
            0% { opacity: 0.3; transform: scale(1); }
            100% { opacity: 0.7; transform: scale(1.1); }
        }
        
        /* Messages avec effets cristallins */
        .message-user {
            background: linear-gradient(135deg, 
                rgba(216, 180, 255, 0.9) 0%,
                rgba(192, 132, 252, 0.9) 50%,
                rgba(168, 85, 247, 0.9) 100%
            );
            color: #2d1b3a;
            box-shadow: 
                0 8px 25px rgba(168, 85, 247, 0.4),
                inset 0 0 20px rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.6);
            position: relative;
            overflow: hidden;
            animation: messageGlow 2s infinite alternate;
        }
        
        .message-bot {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(216, 180, 255, 0.5);
            box-shadow: 
                0 8px 25px rgba(147, 112, 219, 0.2),
                inset 0 0 30px rgba(255, 255, 255, 0.6);
            color: #3a2a4a;
            position: relative;
            overflow: hidden;
        }
        
        @keyframes messageGlow {
            0% { box-shadow: 0 8px 25px rgba(168, 85, 247, 0.4); }
            100% { box-shadow: 0 8px 35px rgba(168, 85, 247, 0.7); }
        }
        
        /* Reflet sur les messages */
        .message-shine {
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                45deg,
                transparent 30%,
                rgba(255, 255, 255, 0.4) 50%,
                transparent 70%
            );
            animation: messageShine 3s infinite;
            pointer-events: none;
        }
        
        @keyframes messageShine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(25deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(25deg); }
        }
        
        /* Input avec effet de cristal liquide */
        .input-crystal {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            color: white;
            box-shadow: inset 0 0 20px rgba(255, 255, 255, 0.2);
        }
        
        .input-crystal:focus {
            background: rgba(255, 255, 255, 0.3);
            border-color: #d8b4ff;
            box-shadow: 
                0 0 30px rgba(216, 180, 255, 0.4),
                inset 0 0 30px rgba(255, 255, 255, 0.4);
            transform: translateY(-2px);
        }
        
        .input-crystal::placeholder {
            color: rgba(255, 255, 255, 0.6);
            font-style: italic;
        }
        
        /* Bouton avec effet de gemme */
        .btn-gem {
            background: linear-gradient(135deg, 
                #d8b4ff 0%,
                #c084fc 40%,
                #a855f7 60%,
                #9333ea 100%
            );
            background-size: 300% 300%;
            animation: gradientFlow 5s ease infinite;
            box-shadow: 
                0 10px 30px rgba(168, 85, 247, 0.5),
                inset 0 0 30px rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.6);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        @keyframes gradientFlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .btn-gem:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 
                0 15px 40px rgba(168, 85, 247, 0.7),
                inset 0 0 40px rgba(255, 255, 255, 0.6);
        }
        
        .btn-gem:active {
            transform: translateY(2px) scale(0.98);
        }
        
        /* Header cristallin */
        .crystal-header {
            background: linear-gradient(135deg, 
                rgba(216, 180, 255, 0.4) 0%,
                rgba(168, 85, 247, 0.4) 50%,
                rgba(147, 51, 234, 0.4) 100%
            );
            backdrop-filter: blur(15px);
            border-bottom: 2px solid rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        /* Scrollbar personnalisée */
        #chat-box::-webkit-scrollbar {
            width: 8px;
        }
        
        #chat-box::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        
        #chat-box::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #d8b4ff, #a855f7);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        #chat-box::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #c084fc, #9333ea);
        }
        
        /* Icônes animées */
        .icon-pulse {
            animation: iconPulse 2s infinite;
        }
        
        @keyframes iconPulse {
            0% { filter: drop-shadow(0 0 5px rgba(216, 180, 255, 0.5)); }
            50% { filter: drop-shadow(0 0 15px rgba(216, 180, 255, 0.8)); }
            100% { filter: drop-shadow(0 0 5px rgba(216, 180, 255, 0.5)); }
        }
        
        /* Container principal pour le centrage */
        .center-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            width: 100%;
            padding: 20px;
            position: relative;
            z-index: 10;
        }
    </style>
</head>
<body>

<!-- Particules flottantes -->
<div id="particles"></div>

<!-- Container de centrage -->
<div class="center-container">
    <div class="crystal-main rounded-3xl flex flex-col h-[700px] relative overflow-hidden">
        <!-- Effet de prisme -->
        <div class="prism-effect"></div>
        
        <!-- Facettes de cristal -->
        <div class="crystal-facet" style="top: 10%; left: 5%; width: 200px; height: 200px; border-radius: 50%;"></div>
        <div class="crystal-facet" style="bottom: 10%; right: 5%; width: 150px; height: 150px; border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;"></div>
        
        <!-- Header avec effets -->
        <div class="crystal-header p-6 text-white font-bold rounded-t-3xl relative">
            <div class="relative flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <i class="fas fa-gem text-3xl icon-pulse" style="color: #d8b4ff;"></i>
                        <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-300 rounded-full animate-ping"></div>
                        <div class="absolute -top-1 -right-1 w-3 h-3 bg-green-400 rounded-full"></div>
                    </div>
                    <div>
                        <h1 class="text-2xl tracking-wider flex items-center gap-2">
                            ✦ CRYSTAL AI ✦
                            <i class="fas fa-sparkle text-sm"></i>
                        </h1>
                        <p class="text-xs text-purple-200 mt-1">Assistant Premium aux reflets cristallins</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <i class="fas fa-circle-notch text-purple-300 animate-spin"></i>
                    <i class="fas fa-sliders-h text-purple-300"></i>
                </div>
            </div>
            
            <!-- Barre lumineuse -->
            <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-white to-transparent animate-pulse"></div>
        </div>
        
        <!-- Chat Box -->
        <div id="chat-box" class="flex-1 overflow-y-auto p-6 space-y-4" style="background: rgba(255, 255, 255, 0.05);">
            <div class="text-left">
                <div class="message-bot p-4 rounded-2xl rounded-tl-none inline-block text-sm max-w-[85%] shadow-lg relative group">
                    <div class="message-shine"></div>
                    <div class="flex items-start gap-3">
                        <i class="fas fa-crystal text-purple-400 mt-1"></i>
                        <div>
                            <span class="font-bold text-purple-700">✨ Ton assistance✨</span>
                            <p class="mt-1">Bonjour ! Je brille de mille feux pour vous servir ! Comment puis-je illuminer votre journée ?</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Zone de saisie cristalline -->
        <div class="p-5 border-t border-white/20 bg-white/5 backdrop-blur-md rounded-b-3xl">
            <div class="flex gap-3">
                <div class="flex-1 relative">
                    <i class="fas fa-gem absolute left-4 top-1/2 transform -translate-y-1/2 text-purple-300"></i>
                    <input type="text" id="user-input" class="input-crystal w-full rounded-2xl pl-12 pr-4 py-4 focus:outline-none" 
                           placeholder="Tapez votre message cristallin...">
                </div>
                <button onclick="sendMessage()" class="btn-gem text-white px-8 py-4 rounded-2xl font-semibold tracking-wide flex items-center gap-2">
                    <span>Envoyer</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>
            
            <!-- Suggestions cristallines -->
            <div class="flex gap-2 mt-3">
                <span class="text-xs px-3 py-1 rounded-full bg-white/10 text-white/70 border border-white/20 hover:bg-white/20 cursor-pointer transition">
                    <i class="fas fa-sparkle mr-1 text-purple-300"></i>Bonjour
                </span>
                <span class="text-xs px-3 py-1 rounded-full bg-white/10 text-white/70 border border-white/20 hover:bg-white/20 cursor-pointer transition">
                    <i class="fas fa-sparkle mr-1 text-purple-300"></i>Aide
                </span>
                <span class="text-xs px-3 py-1 rounded-full bg-white/10 text-white/70 border border-white/20 hover:bg-white/20 cursor-pointer transition">
                    <i class="fas fa-sparkle mr-1 text-purple-300"></i>Fonctionnalités
                </span>
            </div>
        </div>
    </div>
</div>

<script>
// Générer des particules flottantes
function createParticles() {
    const particlesContainer = document.getElementById('particles');
    for (let i = 0; i < 30; i++) {
        const particle = document.createElement('div');
        particle.className = 'floating-particle';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.top = Math.random() * 100 + '%';
        particle.style.animationDelay = Math.random() * 5 + 's';
        particle.style.animationDuration = 5 + Math.random() * 10 + 's';
        particle.style.background = `rgba(200, 168, 255, ${0.1 + Math.random() * 0.4})`;
        particle.style.width = 2 + Math.random() * 8 + 'px';
        particle.style.height = particle.style.width;
        particlesContainer.appendChild(particle);
    }
}

async function sendMessage() {
    const input = document.getElementById('user-input');
    const chatBox = document.getElementById('chat-box');
    const message = input.value.trim();
    if(!message) return;

    // Ajouter le message utilisateur avec effet
    chatBox.innerHTML += `
        <div class="text-right">
            <div class="message-user p-4 rounded-2xl rounded-tr-none inline-block text-sm max-w-[85%] shadow-lg relative">
                <div class="message-shine"></div>
                <div class="flex items-start gap-3 flex-row-reverse">
                    <i class="fas fa-user text-purple-200 mt-1"></i>
                    <div>
                        <span class="font-bold text-purple-900 block text-right">Vous</span>
                        <p class="mt-1 text-white">${message}</p>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    input.value = '';
    chatBox.scrollTop = chatBox.scrollHeight;

    // Animation de typing
    chatBox.innerHTML += `
        <div class="text-left" id="typing-indicator">
            <div class="message-bot p-4 rounded-2xl rounded-tl-none inline-block">
                <div class="flex gap-2">
                    <div class="w-2 h-2 bg-purple-400 rounded-full animate-bounce" style="animation-delay: 0s"></div>
                    <div class="w-2 h-2 bg-purple-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    <div class="w-2 h-2 bg-purple-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                </div>
            </div>
        </div>
    `;

    try {
        const response = await fetch('/chat/send', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: message })
        });

        const data = await response.json();
        
        // Supprimer l'indicateur de typing
        document.getElementById('typing-indicator')?.remove();
        
        // Ajouter la réponse du bot avec effets
        chatBox.innerHTML += `
            <div class="text-left">
                <div class="message-bot p-4 rounded-2xl rounded-tl-none inline-block text-sm max-w-[85%] shadow-lg relative group">
                    <div class="message-shine"></div>
                    <div class="flex items-start gap-3">
                        <i class="fas fa-crystal text-purple-400 mt-1 animate-spin-slow"></i>
                        <div>
                            <span class="font-bold text-purple-700">✨ Crystal ✨</span>
                            <p class="mt-1">${data.reply}</p>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Effet de brillance supplémentaire
        chatBox.lastElementChild.classList.add('animate__animated', 'animate__pulse');
        
    } catch (e) {
        document.getElementById('typing-indicator')?.remove();
        chatBox.innerHTML += `
            <div class="text-left">
                <div class="message-bot p-4 rounded-2xl rounded-tl-none inline-block text-sm max-w-[85%] shadow-lg border-red-300">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-exclamation-triangle text-red-400"></i>
                        <div>
                            <span class="font-bold text-red-500">❌ Erreur</span>
                            <p class="mt-1 text-red-600">Connexion au serveur perdue</p>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    chatBox.scrollTop = chatBox.scrollHeight;
}

// Suggestions cliquables
document.querySelectorAll('.cursor-pointer').forEach(el => {
    el.addEventListener('click', function() {
        const input = document.getElementById('user-input');
        input.value = this.textContent.replace(/^\s*[^\w]*/, '');
        sendMessage();
    });
});

// Envoi avec Entrée
document.getElementById('user-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        sendMessage();
    }
});

// Initialisation
window.onload = function() {
    createParticles();
};
</script>
</body>
</html>