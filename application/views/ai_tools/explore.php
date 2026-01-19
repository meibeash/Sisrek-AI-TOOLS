<!-- Header Section -->
<div class="mb-10">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 mb-2">🔍 Explore AI Tools</h1>
            <p class="text-slate-500">Find and rate AI tools to get personalized recommendations</p>
        </div>
    </div>
</div>

<!-- Search & Filter -->
<div class="bg-white rounded-2xl border p-6 mb-8">
    <form method="GET" action="<?= base_url('tools') ?>" class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="q" placeholder="Search tools..." 
                   value="<?= htmlspecialchars($search ?? '') ?>"
                   class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
        </div>
        <div class="w-48">
            <select name="category" class="w-full px-4 py-3 border rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none">
                <option value="">All Categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>" <?= ($selected_category == $cat) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="bg-purple-600 text-white px-6 py-3 rounded-xl hover:bg-purple-700 transition-colors">
            Search
        </button>
    </form>
</div>

<!-- Important Notice for New Users -->
<?php if (!$this->session->userdata('user_id')): ?>
<div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl p-6 mb-8 text-white">
    <div class="flex items-start gap-4">
        <div class="bg-white/20 rounded-lg p-3">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div>
            <h3 class="font-bold text-lg mb-1">Bagaimana Mendapat Rekomendasi?</h3>
            <p class="text-white/90 text-sm leading-relaxed mb-3">
                <strong>1. Login</strong> ke akun Anda → <strong>2. Beri Rating</strong> pada beberapa tools → <strong>3. Dapatkan Rekomendasi</strong> AI berbasis SVD Collaborative Filtering
            </p>
            <a href="<?= base_url('auth/login') ?>" class="inline-block bg-white text-purple-600 px-5 py-2 rounded-full text-sm font-semibold hover:bg-purple-50 transition-colors">
                Login Sekarang →
            </a>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if (!empty($tools)): ?>

<!-- Results Count -->
<div class="mb-6 text-slate-500">
    Showing <?= count($tools) ?> tools
</div>

<!-- Tools Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach($tools as $tool): ?>
    <div class="bg-white rounded-2xl border hover:shadow-lg transition-all duration-300 overflow-hidden group">
        <!-- Tool Header -->
        <div class="p-5">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-slate-100 to-slate-200 rounded-xl flex items-center justify-center text-slate-600 font-bold text-xl group-hover:scale-110 transition-transform">
                    <?= strtoupper(substr($tool->company_name, 0, 1)) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-slate-800 text-lg"><?= htmlspecialchars($tool->company_name) ?></h3>
                    <p class="text-slate-400 text-sm truncate"><?= htmlspecialchars($tool->category ?? 'General') ?></p>
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
            <div class="flex items-center justify-between mb-4">
                <span class="inline-block px-3 py-1 rounded-full text-xs font-medium <?= $subClass ?>">
                    <?= htmlspecialchars($sub) ?>
                </span>
                <span class="text-slate-400 text-xs"><?= number_format($tool->votes ?? 0) ?> votes</span>
            </div>
            
            <!-- Rating Display -->
            <div class="flex items-center gap-2 mb-4">
                <?php if ($tool->avg_rating > 0): ?>
                    <div class="flex items-center gap-1">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <span class="text-lg <?= $i <= round($tool->avg_rating) ? 'text-yellow-400' : 'text-slate-200' ?>">★</span>
                        <?php endfor; ?>
                    </div>
                    <span class="text-slate-600 font-medium"><?= $tool->avg_rating ?></span>
                    <span class="text-slate-400 text-sm">(<?= $tool->rating_count ?> ratings)</span>
                <?php else: ?>
                    <span class="text-slate-400 text-sm">Belum ada rating</span>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Rating Form (Transaction) -->
        <?php if ($this->session->userdata('user_id')): ?>
        <div class="px-5 pb-5">
            <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl p-4">
                <p class="text-xs text-purple-600 font-medium mb-2">⭐ Beri Rating (Transaksi)</p>
                <form action="<?= base_url('rating/submit') ?>" method="POST" class="flex items-center gap-2">
                    <input type="hidden" name="tool_id" value="<?= $tool->tool_id ?>">
                    <div class="rating-stars flex gap-1" data-tool="<?= $tool->tool_id ?>">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <label class="cursor-pointer">
                                <input type="radio" name="rating" value="<?= $i ?>" class="hidden" required>
                                <span class="star text-2xl text-slate-300 hover:text-yellow-400 transition-colors" data-value="<?= $i ?>">★</span>
                            </label>
                        <?php endfor; ?>
                    </div>
                    <button type="submit" class="ml-auto bg-purple-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-purple-700 transition-colors">
                        Submit
                    </button>
                </form>
            </div>
        </div>
        <?php else: ?>
        <div class="px-5 pb-5">
            <a href="<?= base_url('auth/login') ?>" class="block text-center bg-slate-100 text-slate-600 px-4 py-3 rounded-xl text-sm hover:bg-slate-200 transition-colors">
                Login untuk memberi rating
            </a>
        </div>
        <?php endif; ?>
        
        <!-- View Detail Button -->
        <a href="<?= base_url('tools/detail/' . $tool->tool_id) ?>" 
           class="block bg-slate-50 px-5 py-3 text-center text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-colors border-t">
            View Details →
        </a>
    </div>
    <?php endforeach; ?>
</div>

<?php else: ?>

<div class="text-center py-20">
    <p class="text-6xl mb-4">🔍</p>
    <h3 class="text-xl font-semibold text-slate-800 mb-2">No Tools Found</h3>
    <p class="text-slate-500 mb-6">Try adjusting your search or filters</p>
    <a href="<?= base_url('tools') ?>" class="inline-block bg-slate-900 text-white px-6 py-3 rounded-full hover:bg-slate-700 transition-colors">
        Clear Filters
    </a>
</div>

<?php endif; ?>

<!-- Star Rating Script -->
<script>
document.querySelectorAll('.rating-stars').forEach(container => {
    const stars = container.querySelectorAll('.star');
    stars.forEach((star, index) => {
        star.addEventListener('click', () => {
            stars.forEach((s, i) => {
                s.classList.toggle('text-yellow-400', i <= index);
                s.classList.toggle('text-slate-300', i > index);
            });
        });
        star.addEventListener('mouseenter', () => {
            stars.forEach((s, i) => {
                s.classList.toggle('text-yellow-400', i <= index);
            });
        });
    });
    container.addEventListener('mouseleave', () => {
        const checked = container.querySelector('input:checked');
        if (checked) {
            const val = parseInt(checked.value);
            stars.forEach((s, i) => {
                s.classList.toggle('text-yellow-400', i < val);
                s.classList.toggle('text-slate-300', i >= val);
            });
        } else {
            stars.forEach(s => {
                s.classList.remove('text-yellow-400');
                s.classList.add('text-slate-300');
            });
        }
    });
});
</script>
