<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Maintenance - La Maison P2A</title>
    <meta name="description" content="La Maison P2A est actuellement en maintenance. Nous revenons bientôt avec de nouvelles fonctionnalités.">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800|poppins:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="antialiased bg-white">
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        
        <!-- Geometric Background -->
        <div class="absolute inset-0 overflow-hidden">
            <!-- Animated Shapes -->
            <div class="absolute top-20 -left-20 w-96 h-96 bg-primary-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
            <div class="absolute top-40 -right-20 w-96 h-96 bg-primary-300 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-20 left-1/2 w-96 h-96 bg-primary-200 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>
            
            <!-- Decorative Lines -->
            <svg class="absolute top-0 left-0 w-full h-full opacity-10" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="0.5" class="text-neutral-400"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid)" />
            </svg>
        </div>

        <!-- Main Content -->
        <div class="relative max-w-6xl w-full z-10">
            <div class="text-center space-y-12">
                
                <!-- Logo -->
                <div class="flex justify-center mb-8 animate-fade-in-down">
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-primary-500 to-primary-800 rounded-lg blur opacity-25 group-hover:opacity-40 transition duration-1000"></div>
                        <div class="relative bg-white p-4 rounded-lg">
                            <img src="{{ asset('logo.jpg') }}" alt="La Maison P2A" class="h-24 w-auto object-contain">
                        </div>
                    </div>
                </div>

                <!-- Main Icon -->
                <div class="flex justify-center animate-scale-in">
                    <div class="relative">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary-500 to-primary-800 rounded-3xl blur-2xl opacity-20 animate-pulse-gentle"></div>
                        <div class="relative bg-white rounded-3xl p-8 shadow-2xl transform hover:scale-105 transition-transform duration-300">
                            <img src="{{ asset('support-informatique.png') }}" alt="Maintenance" class="w-32 h-32 object-contain">
                        </div>
                    </div>
                </div>

                <!-- Title Section -->
                <div class="space-y-6 animate-fade-in-up">
                    <h1 class="text-6xl lg:text-7xl font-bold bg-gradient-to-r from-neutral-900 via-neutral-700 to-neutral-900 bg-clip-text text-transparent" style="font-family: 'Poppins', sans-serif;">
                        Maintenance en Cours
                    </h1>
                    <div class="flex items-center justify-center space-x-2">
                        <div class="h-1 w-12 bg-gradient-to-r from-transparent to-primary-500 rounded-full"></div>
                        <div class="h-1 w-12 bg-primary-500 rounded-full"></div>
                        <div class="h-1 w-12 bg-gradient-to-r from-primary-500 to-transparent rounded-full"></div>
                    </div>
                    <p class="text-xl lg:text-2xl text-neutral-600 max-w-3xl mx-auto leading-relaxed font-light">
                        {{ env('MAINTENANCE_MESSAGE', 'Nous améliorons votre expérience. Notre équipe travaille pour vous offrir le meilleur service possible.') }}
                    </p>
                </div>

                <!-- Countdown Timer (Optional) -->
                @if(env('MAINTENANCE_END_TIME'))
                <div class="bg-white rounded-3xl shadow-2xl p-10 max-w-4xl mx-auto border border-neutral-100 animate-fade-in-up" 
                     style="animation-delay: 0.2s;"
                     x-data="{
                         endTime: new Date('{{ env('MAINTENANCE_END_TIME') }}').getTime(),
                         days: 0,
                         hours: 0,
                         minutes: 0,
                         seconds: 0,
                         updateCountdown() {
                             const now = new Date().getTime();
                             const distance = this.endTime - now;
                             
                             if (distance > 0) {
                                 this.days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                 this.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                 this.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                 this.seconds = Math.floor((distance % (1000 * 60)) / 1000);
                             }
                         }
                     }"
                     x-init="updateCountdown(); setInterval(() => updateCountdown(), 1000)">
                    <p class="text-sm font-semibold text-primary-600 uppercase tracking-widest mb-8">Retour Estimé Dans</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="text-center group">
                            <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-2xl p-6 mb-3 group-hover:shadow-lg transition-shadow">
                                <div class="text-5xl lg:text-6xl font-bold bg-gradient-to-br from-primary-600 to-primary-800 bg-clip-text text-transparent" x-text="days">0</div>
                            </div>
                            <div class="text-sm font-medium text-neutral-600 uppercase tracking-wider">Jours</div>
                        </div>
                        <div class="text-center group">
                            <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-2xl p-6 mb-3 group-hover:shadow-lg transition-shadow">
                                <div class="text-5xl lg:text-6xl font-bold bg-gradient-to-br from-primary-600 to-primary-800 bg-clip-text text-transparent" x-text="hours">0</div>
                            </div>
                            <div class="text-sm font-medium text-neutral-600 uppercase tracking-wider">Heures</div>
                        </div>
                        <div class="text-center group">
                            <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-2xl p-6 mb-3 group-hover:shadow-lg transition-shadow">
                                <div class="text-5xl lg:text-6xl font-bold bg-gradient-to-br from-primary-600 to-primary-800 bg-clip-text text-transparent" x-text="minutes">0</div>
                            </div>
                            <div class="text-sm font-medium text-neutral-600 uppercase tracking-wider">Minutes</div>
                        </div>
                        <div class="text-center group">
                            <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-2xl p-6 mb-3 group-hover:shadow-lg transition-shadow">
                                <div class="text-5xl lg:text-6xl font-bold bg-gradient-to-br from-primary-600 to-primary-800 bg-clip-text text-transparent" x-text="seconds">0</div>
                            </div>
                            <div class="text-sm font-medium text-neutral-600 uppercase tracking-wider">Secondes</div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Info Cards Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto animate-fade-in-up" style="animation-delay: 0.3s;">
                    
                    <!-- Card 1: Info -->
                    <div class="bg-white rounded-2xl p-8 shadow-xl border border-neutral-100 hover:shadow-2xl transition-all duration-300 group">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900 mb-3">Que se passe-t-il ?</h3>
                        <p class="text-neutral-600 leading-relaxed">
                            Nous perfectionnons notre plateforme pour vous offrir une expérience exceptionnelle.
                        </p>
                    </div>

                    <!-- Card 2: Social -->
                    <div class="bg-white rounded-2xl p-8 shadow-xl border border-neutral-100 hover:shadow-2xl transition-all duration-300 group">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900 mb-4">Suivez-nous</h3>
                        <div class="flex items-center justify-center space-x-3">
                            <a href="https://www.facebook.com/profile.php?id=61582522333813" target="_blank"
                                class="w-12 h-12 bg-neutral-100 rounded-xl flex items-center justify-center hover:bg-primary-500 hover:text-white transition-all hover:scale-110 group/icon">
                                <svg class="w-5 h-5 text-neutral-600 group-hover/icon:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                            </a>
                            <a href="https://www.instagram.com/lamaisonp2a?igsh=ZHg1czEwZ3JoOWlm&utm_source=ig_contact_invite" target="_blank"
                                class="w-12 h-12 bg-neutral-100 rounded-xl flex items-center justify-center hover:bg-primary-500 hover:text-white transition-all hover:scale-110 group/icon">
                                <svg class="w-5 h-5 text-neutral-600 group-hover/icon:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
                            </a>
                            <a href="https://www.tiktok.com/@la.maison.p2a?_r=1&_t=ZN-91jY4jK9HUs" target="_blank"
                                class="w-12 h-12 bg-neutral-100 rounded-xl flex items-center justify-center hover:bg-primary-500 hover:text-white transition-all hover:scale-110 group/icon">
                                <svg class="w-5 h-5 text-neutral-600 group-hover/icon:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Card 3: Contact -->
                    <div class="bg-white rounded-2xl p-8 shadow-xl border border-neutral-100  hover:shadow-2xl transition-all duration-300 group">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900 mb-3">Besoin d'aide ?</h3>
                        <p class="text-neutral-600 mb-4">Notre équipe reste disponible</p>
                        <div class="space-y-2">
                            <a href="mailto:Lamaisonp2a@outlook.com" class="block text-sm text-primary-600 hover:text-primary-700 font-medium">
                                Lamaisonp2a@outlook.com
                            </a>
                            <a href="tel:0033782215485" class="block text-sm text-primary-600 hover:text-primary-700 font-medium">
                                +33 7 82 21 54 85
                            </a>
                        </div>
                    </div>
                </div>

                <!-- CTA Section -->
                <div class="bg-gradient-to-r from-primary-500 to-primary-800  rounded-3xl shadow-2xl p-10 max-w-4xl mx-auto animate-fade-in-up" style="animation-delay: 0.4s;">
                    <h3 class="text-3xl font-bold text-white mb-4" style="font-family: 'Poppins', sans-serif;">Merci de Votre Patience</h3>
                    <p class="text-white font-bold text-lg mb-6">
                        Nous travaillons dur pour améliorer votre expérience. Retour à la normale le 01/01/2026
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-4">
                        <a href="mailto:Lamaisonp2a@outlook.com" class="inline-flex items-center space-x-2 bg-white text-primary-600 px-8 py-4 rounded-xl font-semibold hover:bg-primary-50 transition-all shadow-lg hover:shadow-xl hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>Nous Contacter</span>
                        </a>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center text-neutral-500 text-sm animate-fade-in-up pt-8" style="animation-delay: 0.6s;">
                    <div class="flex items-center justify-center space-x-4 mb-4">
                        <div class="h-px w-16 bg-neutral-300"></div>
                        <svg class="w-5 h-5 text-primary-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <div class="h-px w-16 bg-neutral-300"></div>
                    </div>
                    <p class="text-neutral-700 font-medium">&copy; {{ date('Y') }} <span class="text-primary-600">La Maison P2A</span></p>
                    <p class="mt-2 text-neutral-500">Votre spécialiste en décoration d'intérieur et d'événements</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Blob Animation */
        @keyframes blob {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(30px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        /* Fade Animations */
        @keyframes fade-in-down {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scale-in {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes pulse-gentle {
            0%, 100% {
                opacity: 0.2;
            }
            50% {
                opacity: 0.3;
            }
        }

        .animate-fade-in-down {
            animation: fade-in-down 0.6s ease-out;
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out;
        }

        .animate-scale-in {
            animation: scale-in 0.8s ease-out;
        }

        .animate-pulse-gentle {
            animation: pulse-gentle 3s ease-in-out infinite;
        }
    </style>
</body>

</html>
