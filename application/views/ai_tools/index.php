<?php 
$is_recommendation = isset($is_recommendation) && $is_recommendation;
$is_logged_in = isset($is_logged_in) && $is_logged_in;
$has_ratings = isset($has_ratings) && $has_ratings;
?>

<!-- Header: Dynamic based on mode -->
<div class="mb-10">
    <?php if ($is_recommendation): ?>
        <h1 class="text-3xl font-bold text-slate-800 mb-2">✨ For You</h1>
        <p class="text-slate-500">Personalized recommendations based on your ratings</p>
    <?php else: ?>
        <h1 class="text-3xl font-bold text-slate-800 mb-2">🔥 Trending AI Tools</h1>
        <p class="text-slate-500">Most popular tools based on community votes</p>
    <?php endif; ?>
</div>

<?php if ($is_recommendation): ?>
<!-- Content-Based Filtering Banner -->
<div class="bg-purple-50 border border-purple-100 rounded-xl p-5 mb-10 flex items-center gap-4">
    <span class="text-3xl">🎯</span>
    <div>
        <p class="text-purple-800 font-medium">Personalized for You (Cosine Similarity)</p>
        <p class="text-purple-600 text-sm">Based on your rating profile, we found similar tools you might like.</p>
    </div>
</div>
<?php elseif (!$is_logged_in): ?>
<!-- CTA Banner (for guests) -->
<div class="bg-gradient-to-r from-violet-500 to-purple-600 rounded-2xl p-8 mb-10 text-white">
    <h2 class="text-xl font-semibold mb-2">Get Personal Recommendations</h2>
    <p class="text-white/80 mb-4">Sign up and rate tools to get AI-powered recommendations tailored just for you.</p>
    <a href="<?= base_url('auth/register') ?>" class="inline-block bg-white text-purple-600 px-6 py-2 rounded-full font-medium hover:bg-purple-50">
        Get Started →
    </a>
</div>
<?php elseif ($is_logged_in && !$has_ratings): ?>
<!-- Prompt to rate (for logged-in users without ratings) -->
<div class="bg-blue-50 border border-blue-100 rounded-xl p-5 mb-10 flex items-center gap-4">
    <span class="text-3xl">⭐</span>
    <div class="flex-1">
        <p class="text-blue-800 font-medium">Start rating to unlock recommendations!</p>
        <p class="text-blue-600 text-sm">Rate a few AI tools below and we'll personalize your homepage.</p>
    </div>
</div>
<?php endif; ?>

<!-- Tools Grid -->
<?php if (!empty($tools)): ?>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    <?php foreach ($tools as $i => $tool): ?>
    <a href="<?= base_url('tools/detail/'.$tool->tool_id) ?>" 
       class="group bg-white rounded-xl p-5 border border-slate-200 hover:border-purple-300 hover:shadow-lg transition-all">
        
        <?php if ($is_recommendation): ?>
            <!-- Recommendation mode: show initial avatar -->
            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-violet-600 rounded-lg flex items-center justify-center text-white text-sm font-bold mb-4">
                <?= strtoupper(substr($tool->company_name, 0, 1)) ?>
            </div>
        <?php else: ?>
            <!-- Trending mode: show rank badge for top 3 -->
            <?php if ($i < 3): ?>
                <span class="text-xs font-medium px-2 py-1 rounded-full mb-3 inline-block
                    <?= $i === 0 ? 'bg-yellow-100 text-yellow-700' : ($i === 1 ? 'bg-slate-100 text-slate-600' : 'bg-orange-100 text-orange-700') ?>">
                    #<?= $i + 1 ?>
                </span>
            <?php endif; ?>
        <?php endif; ?>
        
        <h3 class="font-semibold text-slate-800 group-hover:text-purple-600 mb-2">
            <?= htmlspecialchars($tool->company_name) ?>
        </h3>
        
        <p class="text-slate-400 text-sm mb-3"><?= htmlspecialchars($tool->category ?? 'AI Tool') ?></p>
        
        <!-- Rating Display -->
        <div class="flex items-center gap-1 mb-4">
            <?php 
            $avg = $tool->avg_rating ?? 0;
            $count = $tool->rating_count ?? 0;
            for($s = 1; $s <= 5; $s++): 
                $filled = $s <= round($avg);
            ?>
            <span class="text-sm <?= $filled ? 'text-yellow-400' : 'text-slate-200' ?>">★</span>
            <?php endfor; ?>
            <span class="text-xs text-slate-400 ml-1">
                <?php if ($count > 0): ?>
                    <?= $avg ?> (<?= $count ?>)
                <?php else: ?>
                    No ratings
                <?php endif; ?>
            </span>
        </div>
        
        <div class="flex items-center justify-between">
            <span class="text-xs px-2 py-1 rounded-full <?= strtolower($tool->subscription ?? '') === 'free' ? 'bg-green-50 text-green-600' : 'bg-slate-100 text-slate-500' ?>">
                <?= strtolower($tool->subscription ?? '') === 'free' ? 'Free' : ($tool->subscription ?? 'Paid') ?>
            </span>
            <?php if (!$is_recommendation && !empty($tool->votes)): ?>
            <span class="text-slate-400 text-sm">
                ↑ <?= number_format($tool->votes) ?>
            </span>
            <?php elseif ($is_recommendation): ?>
            <span class="text-purple-500 text-sm opacity-0 group-hover:opacity-100 transition">
                View →
            </span>
            <?php endif; ?>
        </div>
    </a>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="text-center py-20 text-slate-400">
    <p class="text-5xl mb-4">🤖</p>
    <p>No AI tools available yet.</p>
</div>
<?php endif; ?>
