<!-- Header Section -->
<div class="mb-10">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <?php if ($is_recommendation): ?>
                <h1 class="text-3xl font-bold text-slate-800 mb-2">🎯 Recommended for You</h1>
                <p class="text-slate-500">Personalized AI tools based on your preferences</p>
            <?php else: ?>
                <h1 class="text-3xl font-bold text-slate-800 mb-2">🔥 Popular AI Tools</h1>
                <p class="text-slate-500">Discover the most popular AI tools</p>
            <?php endif; ?>
        </div>
        
        <?php if (!empty($algorithm)): ?>
        <span class="inline-flex items-center gap-2 <?= strpos($algorithm, 'SVD') !== false ? 'bg-purple-100 text-purple-700' : 'bg-slate-100 text-slate-600' ?> px-4 py-2 rounded-full text-sm font-medium">
            <?php if (strpos($algorithm, 'SVD') !== false): ?>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                </svg>
            <?php endif; ?>
            <?= htmlspecialchars($algorithm) ?>
        </span>
        <?php endif; ?>
    </div>
</div>

<?php if ($this->session->flashdata('success')): ?>
<div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-xl mb-6">
    <?= $this->session->flashdata('success') ?>
</div>
<?php endif; ?>

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

<!-- CTA Section -->
<div class="mt-10 text-center">
    <?php if ($is_logged_in && $has_ratings): ?>
        <a href="<?= base_url('recommendation') ?>" class="inline-block bg-purple-600 text-white px-6 py-3 rounded-full hover:bg-purple-700 transition-colors">
            View All Recommendations →
        </a>
    <?php elseif ($is_logged_in): ?>
        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 inline-block">
            <p class="text-blue-800 mb-3">Rate some tools to get personalized recommendations!</p>
            <a href="<?= base_url('tools') ?>" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-full hover:bg-blue-700 transition-colors">
                Explore & Rate Tools
            </a>
        </div>
    <?php else: ?>
        <div class="bg-slate-50 border rounded-2xl p-6 inline-block">
            <p class="text-slate-600 mb-3">Login to get personalized AI recommendations</p>
            <a href="<?= base_url('auth/login') ?>" class="inline-block bg-slate-900 text-white px-6 py-3 rounded-full hover:bg-slate-700 transition-colors">
                Login Now
            </a>
        </div>
    <?php endif; ?>
</div>

<?php else: ?>

<div class="text-center py-20">
    <p class="text-6xl mb-4">🔍</p>
    <h3 class="text-xl font-semibold text-slate-800 mb-2">No Tools Found</h3>
    <p class="text-slate-500">Check back later for more AI tools</p>
</div>

<?php endif; ?>
