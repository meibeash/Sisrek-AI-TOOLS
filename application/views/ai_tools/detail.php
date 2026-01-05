<!-- Back -->
<a href="javascript:history.back()" class="inline-flex items-center text-slate-500 hover:text-slate-800 mb-8 text-sm">
    ← Back
</a>

<?php if ($tool): ?>
<div class="grid lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border p-8">
            <!-- Header -->
            <div class="flex items-start gap-4 mb-6">
                <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-violet-600 rounded-xl flex items-center justify-center text-white text-xl font-bold shrink-0">
                    <?= strtoupper(substr($tool->company_name, 0, 1)) ?>
                </div>
                <div>
                    <span class="text-xs text-slate-400 uppercase tracking-wide"><?= htmlspecialchars($tool->category ?? 'AI Tool') ?></span>
                    <h1 class="text-2xl font-bold text-slate-800"><?= htmlspecialchars($tool->company_name) ?></h1>
                </div>
            </div>
            
            <!-- Tags -->
            <div class="flex flex-wrap gap-2 mb-6">
                <span class="text-xs px-3 py-1 rounded-full <?= strtolower($tool->subscription ?? '') === 'free' ? 'bg-green-50 text-green-600' : 'bg-orange-50 text-orange-600' ?>">
                    <?= strtolower($tool->subscription ?? '') === 'free' ? '✓ Free' : '💎 ' . ($tool->subscription ?? 'Paid') ?>
                </span>
                <?php if (!empty($tool->votes)): ?>
                <span class="text-xs px-3 py-1 rounded-full bg-slate-100 text-slate-600">
                    ↑ <?= number_format($tool->votes) ?> votes
                </span>
                <?php endif; ?>
            </div>
            
            <!-- Rating Stats -->
            <div class="bg-slate-50 rounded-xl p-4 mb-6">
                <div class="flex items-center gap-3">
                    <div class="text-3xl font-bold text-slate-800">
                        <?= $tool->avg_rating ?? 0 ?>
                    </div>
                    <div>
                        <div class="flex items-center gap-0.5">
                            <?php 
                            $avg = $tool->avg_rating ?? 0;
                            for($s = 1; $s <= 5; $s++): 
                                $filled = $s <= round($avg);
                            ?>
                            <span class="text-lg <?= $filled ? 'text-yellow-400' : 'text-slate-300' ?>">★</span>
                            <?php endfor; ?>
                        </div>
                        <p class="text-slate-500 text-sm">
                            <?= $tool->rating_count ?? 0 ?> rating<?= ($tool->rating_count ?? 0) != 1 ? 's' : '' ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Description -->
            <?php if (!empty($tool->description)): ?>
            <div class="prose prose-slate max-w-none">
                <p class="text-slate-600 leading-relaxed"><?= nl2br(htmlspecialchars($tool->description)) ?></p>
            </div>
            <?php else: ?>
            <p class="text-slate-400 italic">No description available.</p>
            <?php endif; ?>
            
            <!-- Website -->
            <?php if (!empty($tool->url)): ?>
            <a href="<?= htmlspecialchars($tool->url) ?>" target="_blank" 
               class="inline-flex items-center gap-2 mt-6 text-purple-600 hover:text-purple-800 font-medium">
                Visit Website <i class="fas fa-external-link-alt text-xs"></i>
            </a>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Sidebar: Rating -->
    <div>
        <div class="bg-white rounded-2xl border p-6 sticky top-20">
            <h3 class="font-semibold text-slate-800 mb-4">Rate this tool</h3>
            
            <?php if ($this->session->userdata('user_id')): ?>
            <form method="post" action="<?= base_url('rating/submit') ?>" id="ratingForm">
                <input type="hidden" name="tool_id" value="<?= $tool->tool_id ?>">
                <input type="hidden" name="rating" id="ratingValue" value="0">
                
                <!-- Stars -->
                <div class="flex justify-center gap-1 mb-4" id="stars">
                    <?php for($i = 1; $i <= 5; $i++): ?>
                    <button type="button" data-val="<?= $i ?>" 
                            class="star text-3xl text-slate-200 hover:text-yellow-400 transition focus:outline-none">
                        ★
                    </button>
                    <?php endfor; ?>
                </div>
                
                <p class="text-center text-slate-400 text-sm mb-4" id="ratingLabel">Click to rate</p>
                
                <button type="submit" id="submitBtn" disabled
                        class="w-full bg-slate-900 text-white py-3 rounded-xl font-medium hover:bg-slate-700 disabled:bg-slate-200 disabled:text-slate-400 disabled:cursor-not-allowed transition">
                    Submit Rating
                </button>
            </form>
            
            <script>
                const stars = document.querySelectorAll('.star');
                const ratingValue = document.getElementById('ratingValue');
                const ratingLabel = document.getElementById('ratingLabel');
                const submitBtn = document.getElementById('submitBtn');
                const labels = ['', 'Poor', 'Fair', 'Good', 'Great', 'Amazing!'];
                
                stars.forEach(star => {
                    star.addEventListener('click', () => {
                        const val = parseInt(star.dataset.val);
                        ratingValue.value = val;
                        ratingLabel.textContent = labels[val];
                        submitBtn.disabled = false;
                        
                        stars.forEach((s, i) => {
                            s.classList.toggle('text-yellow-400', i < val);
                            s.classList.toggle('text-slate-200', i >= val);
                        });
                    });
                });
            </script>
            <?php else: ?>
            <p class="text-slate-500 text-sm mb-4">Login to rate this tool</p>
            <a href="<?= base_url('auth/login') ?>" 
               class="block text-center bg-slate-900 text-white py-3 rounded-xl font-medium hover:bg-slate-700">
                Login
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php else: ?>
<div class="text-center py-20">
    <p class="text-5xl mb-4">❌</p>
    <p class="text-slate-500 mb-6">Tool not found</p>
    <a href="<?= base_url('tools') ?>" class="inline-block bg-slate-900 text-white px-6 py-3 rounded-full hover:bg-slate-700">
        Browse Tools
    </a>
</div>
<?php endif; ?>
