<x-layout>
    <style>
        @keyframes gradientFlow {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .animate-mesh {
            background: linear-gradient(-45deg, #1cb845, #07cc77, #d3bc0b, #020617);
            background-size: 400% 400%;
            animation: gradientFlow 10s ease infinite;
        }

        .glass-card {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>

    <div class="min-h-screen animate-mesh py-12 px-4 sm:px-6 lg:px-8 font-sans antialiased flex items-center">
        <div class="max-w-xl mx-auto w-full">
            
            <div class="glass-card rounded-3xl shadow-2xl overflow-hidden">
                
                <div class="px-8 pt-8 pb-6 bg-gradient-to-b from-white/5 to-transparent">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-indigo-500/20 rounded-2xl ring-1 ring-indigo-400/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-white tracking-tight">Posts Manager</h1>
                            
                        </div>
                    </div>
                    <div>
                        <p class="mt-6 text-xs text-indigo-300 uppercase tracking-widest font-bold opacity-70">{{ $post->description }}</p>
                    </div>
                </div>
            
            </div>

            <div class="text-center mt-8">
                <p class="text-slate-500 text-[10px] uppercase tracking-[0.3em] font-bold">
                    University of Mindanao • Data Systems
                </p>
            </div>
        </div>
    </div>
</x-layout>