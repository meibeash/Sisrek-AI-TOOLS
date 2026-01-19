<!-- Breadcrumb -->
<div class="mb-6">
    <a href="<?= base_url('tools') ?>" class="text-purple-600 hover:text-purple-800">← Back to Explore</a>
</div>

<?php if ($tool): ?>

<div class="grid lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        <!-- Tool Header Card -->
        <div class="bg-white rounded-2xl border p-8 mb-6">
            <div class="flex items-start gap-6">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-100 to-indigo-200 rounded-2xl flex items-center justify-center text-purple-600 font-bold text-3xl flex-shrink-0">
                    <?= strtoupper(substr($tool->company_name, 0, 1)) ?>
                </div>
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-slate-800 mb-2"><?= htmlspecialchars($tool->company_name) ?></h1>
                    <p class="text-slate-500 mb-4"><?= htmlspecialchars($tool->category ?? 'General') ?></p>
                    
                    <div class="flex flex-wrap gap-3">
                        <!-- Subscription Badge -->
                        <?php 
                            $sub = $tool->subscription ?? 'Unknown';
                            $subColors = [
                                'Free' => 'bg-green-100 text-green-700 border-green-200',
                                'Freemium' => 'bg-blue-100 text-blue-700 border-blue-200',
                                'Paid' => 'bg-orange-100 text-orange-700 border-orange-200',
                                'Free Trial' => 'bg-purple-100 text-purple-700 border-purple-200'
                            ];
                            $subClass = $subColors[$sub] ?? 'bg-slate-100 text-slate-600 border-slate-200';
                        ?>
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium border <?= $subClass ?>">
                            💳 <?= htmlspecialchars($sub) ?>
                        </span>
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-slate-100 text-slate-600 border border-slate-200">
                            👍 <?= number_format($tool->votes ?? 0) ?> votes
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Rating Statistics -->
        <div class="bg-white rounded-2xl border p-6 mb-6">
            <h3 class="font-bold text-lg text-slate-800 mb-4">📊 Rating Statistics</h3>
            
            <?php if ($tool->avg_rating > 0): ?>
            <div class="flex items-center gap-6">
                <div class="text-center">
                    <div class="text-5xl font-bold text-slate-800"><?= $tool->avg_rating ?></div>
                    <div class="flex justify-center mt-2">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <span class="text-2xl <?= $i <= round($tool->avg_rating) ? 'text-yellow-400' : 'text-slate-200' ?>">★</span>
                        <?php endfor; ?>
                    </div>
                    <div class="text-slate-500 text-sm mt-1"><?= $tool->rating_count ?> ratings</div>
                </div>
                <div class="flex-1">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4">
                        <p class="text-green-700 text-sm">
                            <strong>Tool ini memiliki rating bagus!</strong><br>
                            Berdasarkan <?= $tool->rating_count ?> transaksi rating dari pengguna lain.
                        </p>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="text-center py-6 bg-slate-50 rounded-xl">
                <p class="text-slate-500">Belum ada rating untuk tool ini</p>
                <p class="text-slate-400 text-sm">Jadilah yang pertama memberi rating!</p>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Description -->
        <?php if (!empty($tool->clean_text)): ?>
        <div class="bg-white rounded-2xl border p-6">
            <h3 class="font-bold text-lg text-slate-800 mb-4">📝 Description</h3>
            <p class="text-slate-600 leading-relaxed"><?= nl2br(htmlspecialchars($tool->clean_text)) ?></p>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Sidebar - Rating Transaction -->
    <div class="lg:col-span-1">
        <!-- Rating Form Card -->
        <div class="bg-gradient-to-br from-purple-600 to-indigo-700 rounded-2xl p-6 text-white sticky top-20">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl">⭐</span>
                </div>
                <h3 class="font-bold text-xl mb-2">Beri Rating</h3>
                <p class="text-white/80 text-sm">Rating Anda menjadi transaksi untuk sistem rekomendasi AI</p>
            </div>
            
            <?php if ($this->session->userdata('user_id')): ?>
            <form action="<?= base_url('rating/submit') ?>" method="POST">
                <input type="hidden" name="tool_id" value="<?= $tool->tool_id ?>">
                
                <!-- Star Rating -->
                <div class="bg-white/10 rounded-xl p-4 mb-4">
                    <p class="text-center text-white/70 text-sm mb-3">Pilih rating Anda:</p>
                    <div class="flex justify-center gap-2" id="detail-rating-stars">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="<?= $i ?>" class="hidden" required>
                                <span class="star text-4xl text-white/40 hover:text-yellow-400 transition-all hover:scale-110" data-value="<?= $i ?>">★</span>
                            </label>
                        <?php endfor; ?>
                    </div>
                </div>
                
                <button type="submit" class="w-full bg-white text-purple-700 py-4 rounded-xl font-bold text-lg hover:bg-purple-50 transition-colors">
                    Submit Rating →
                </button>
            </form>
            
            <div class="mt-4 pt-4 border-t border-white/20">
                <p class="text-white/70 text-xs text-center">
                    Setelah submit rating, kunjungi halaman 
                    <a href="<?= base_url('recommendation') ?>" class="underline text-white">Recommendations</a> 
                    untuk melihat rekomendasi AI berdasarkan preferensi Anda.
                </p>
            </div>
            
            <?php else: ?>
            <div class="bg-white/10 rounded-xl p-6 text-center">
                <p class="text-white/80 mb-4">Login untuk memberi rating dan mendapatkan rekomendasi AI</p>
                <a href="<?= base_url('auth/login') ?>" class="block w-full bg-white text-purple-700 py-3 rounded-xl font-bold hover:bg-purple-50 transition-colors">
                    Login Sekarang
                </a>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- How It Works Card -->
        <div class="bg-white rounded-2xl border p-6 mt-6">
            <h4 class="font-bold text-slate-800 mb-4">🔬 Cara Kerja Rekomendasi</h4>
            <div class="space-y-4">
                <div class="flex gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center font-bold text-sm">1</div>
                    <div>
                        <p class="font-medium text-slate-800">Transaksi Rating</p>
                        <p class="text-slate-500 text-sm">Anda memberikan rating pada tools yang sudah Anda gunakan</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center font-bold text-sm">2</div>
                    <div>
                        <p class="font-medium text-slate-800">Analisis SVD</p>
                        <p class="text-slate-500 text-sm">AI menganalisis pola rating Anda dan user lain</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center font-bold text-sm">3</div>
                    <div>
                        <p class="font-medium text-slate-800">Prediksi Rating</p>
                        <p class="text-slate-500 text-sm">Sistem memprediksi rating Anda untuk tools lain</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="flex-shrink-0 w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center font-bold text-sm">✓</div>
                    <div>
                        <p class="font-medium text-slate-800">Rekomendasi</p>
                        <p class="text-slate-500 text-sm">Tools dengan predicted rating tertinggi direkomendasikan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Star Rating Script -->
<script>
document.querySelectorAll('#detail-rating-stars .star').forEach((star, index, stars) => {
    star.addEventListener('click', () => {
        stars.forEach((s, i) => {
            s.classList.toggle('text-yellow-400', i <= index);
            s.classList.toggle('text-white/40', i > index);
        });
    });
    star.addEventListener('mouseenter', () => {
        stars.forEach((s, i) => {
            s.classList.toggle('text-yellow-400', i <= index);
        });
    });
});

document.getElementById('detail-rating-stars')?.addEventListener('mouseleave', () => {
    const stars = document.querySelectorAll('#detail-rating-stars .star');
    const checked = document.querySelector('#detail-rating-stars input:checked');
    if (checked) {
        const val = parseInt(checked.value);
        stars.forEach((s, i) => {
            s.classList.toggle('text-yellow-400', i < val);
            s.classList.toggle('text-white/40', i >= val);
        });
    } else {
        stars.forEach(s => {
            s.classList.remove('text-yellow-400');
            s.classList.add('text-white/40');
        });
    }
});
</script>

<?php else: ?>

<div class="text-center py-20">
    <p class="text-6xl mb-4">❓</p>
    <h3 class="text-xl font-semibold text-slate-800 mb-2">Tool Not Found</h3>
    <p class="text-slate-500 mb-6">The tool you're looking for doesn't exist</p>
    <a href="<?= base_url('tools') ?>" class="inline-block bg-slate-900 text-white px-6 py-3 rounded-full hover:bg-slate-700 transition-colors">
        Back to Explore
    </a>
</div>

<?php endif; ?>
