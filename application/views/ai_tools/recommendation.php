<!-- Header Section -->
<div class="mb-10">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 mb-2">🎯 Recommended for You</h1>
            <p class="text-slate-500">Personalized recommendations using AI</p>
        </div>
        
        <!-- Algorithm Badge -->
        <div class="flex items-center gap-3">
            <?php if ($svd_success): ?>
                <span class="inline-flex items-center gap-2 bg-purple-100 text-purple-700 px-4 py-2 rounded-full text-sm font-medium">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                    </svg>
                    SVD Collaborative Filtering
                </span>
            <?php else: ?>
                <span class="inline-flex items-center gap-2 bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full text-sm font-medium">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    Content-Based (Fallback)
                </span>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Algorithm Explanation Card -->
<div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-6 mb-8 text-white">
    <div class="flex items-start gap-4">
        <div class="bg-white/20 rounded-lg p-3">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
            </svg>
        </div>
        <div>
            <h3 class="font-bold text-lg mb-1">Model-Based Collaborative Filtering</h3>
            <p class="text-white/80 text-sm leading-relaxed">
                Rekomendasi ini dihasilkan menggunakan algoritma <strong>SVD (Singular Value Decomposition)</strong> 
                yang menganalisis pola rating dari semua pengguna untuk menemukan preferensi tersembunyi Anda.
            </p>
        </div>
    </div>
</div>

<?php if (!empty($tools)): ?>

<!-- Tools Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <?php foreach($tools as $tool): ?>
    <div class="bg-white rounded-2xl border hover:shadow-lg transition-all duration-300 overflow-hidden group">
        <!-- Tool Header -->
        <div class="p-5">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-slate-100 to-slate-200 rounded-xl flex items-center justify-center text-slate-600 font-bold text-lg group-hover:scale-110 transition-transform">
                    <?= strtoupper(substr($tool->company_name, 0, 1)) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-slate-800 truncate"><?= htmlspecialchars($tool->company_name) ?></h3>
                    <p class="text-slate-400 text-xs truncate"><?= htmlspecialchars($tool->category ?? 'General') ?></p>
                </div>
            </div>
            
            <!-- Subscription Badge -->
            <?php 
                $sub = $tool->subscription ?? 'Unknown';
                $subColors = [
                    'Free' => 'bg-green-100 text-green-700',
                    'Freemium' => 'bg-blue-100 text-blue-700',
                    'Paid' => 'bg-orange-100 text-orange-700',
                    'Free Trial' => 'bg-purple-100 text-purple-700'
                ];
                $subClass = $subColors[$sub] ?? 'bg-slate-100 text-slate-600';
            ?>
            <span class="inline-block px-3 py-1 rounded-full text-xs font-medium <?= $subClass ?>">
                <?= htmlspecialchars($sub) ?>
            </span>
        </div>
        
        <!-- Prediction & Rating Section -->
        <div class="px-5 pb-5">
            <?php if (isset($predictions[$tool->tool_id])): ?>
            <!-- SVD Predicted Rating -->
            <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl p-3 mb-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs text-purple-600 font-medium">Predicted Rating</span>
                    <div class="flex items-center gap-1">
                        <span class="text-purple-700 font-bold"><?= number_format($predictions[$tool->tool_id], 1) ?></span>
                        <span class="text-yellow-400">★</span>
                    </div>
                </div>
                <div class="mt-2 h-2 bg-purple-200 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full" 
                         style="width: <?= ($predictions[$tool->tool_id] / 5) * 100 ?>%"></div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Actual Ratings -->
            <div class="flex items-center justify-between text-sm">
                <div class="flex items-center gap-1">
                    <?php if ($tool->avg_rating > 0): ?>
                        <span class="text-yellow-400">★</span>
                        <span class="text-slate-600 font-medium"><?= $tool->avg_rating ?></span>
                        <span class="text-slate-400">(<?= $tool->rating_count ?>)</span>
                    <?php else: ?>
                        <span class="text-slate-400">No ratings yet</span>
                    <?php endif; ?>
                </div>
                <span class="text-slate-400 text-xs"><?= number_format($tool->votes ?? 0) ?> votes</span>
            </div>
        </div>
        
        <!-- Action Button -->
        <a href="<?= base_url('tools/detail/' . $tool->tool_id) ?>" 
           class="block bg-slate-50 px-5 py-3 text-center text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors">
            View Details →
        </a>
    </div>
    <?php endforeach; ?>
</div>

<!-- How It Works Section -->
<div class="mt-12 bg-white rounded-2xl border p-6">
    <h3 class="font-bold text-lg text-slate-800 mb-4">🔬 How SVD Collaborative Filtering Works</h3>
    <div class="grid md:grid-cols-3 gap-6">
        <div class="flex gap-3">
            <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 font-bold">1</div>
            <div>
                <h4 class="font-medium text-slate-800">Matrix Factorization</h4>
                <p class="text-slate-500 text-sm">Memecah matriks rating user-item menjadi latent factors</p>
            </div>
        </div>
        <div class="flex gap-3">
            <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 font-bold">2</div>
            <div>
                <h4 class="font-medium text-slate-800">Pattern Discovery</h4>
                <p class="text-slate-500 text-sm">Menemukan pola tersembunyi dari preferensi semua user</p>
            </div>
        </div>
        <div class="flex gap-3">
            <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 font-bold">3</div>
            <div>
                <h4 class="font-medium text-slate-800">Rating Prediction</h4>
                <p class="text-slate-500 text-sm">Memprediksi rating untuk tools yang belum Anda coba</p>
            </div>
        </div>
    </div>
</div>

<?php else: ?>

<!-- Empty State -->
<div class="text-center py-20">
    <p class="text-6xl mb-4">🎯</p>
    <h3 class="text-xl font-semibold text-slate-800 mb-2">No Recommendations Yet</h3>
    <p class="text-slate-500 mb-6">Start rating some tools to get personalized recommendations</p>
    <a href="<?= base_url('tools') ?>" class="inline-block bg-purple-600 text-white px-6 py-3 rounded-full hover:bg-purple-700 transition-colors">
        Explore Tools
    </a>
</div>

<?php endif; ?>
