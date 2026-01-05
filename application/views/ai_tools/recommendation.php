<!-- Header -->
<div class="mb-10">
    <h1 class="text-3xl font-bold text-slate-800 mb-2">✨ For You</h1>
    <p class="text-slate-500">Personalized recommendations based on your ratings</p>
</div>

<!-- Info -->
<div class="bg-purple-50 border border-purple-100 rounded-xl p-5 mb-10 flex items-center gap-4">
    <span class="text-3xl">🎯</span>
    <div>
        <p class="text-purple-800 font-medium">Personalized for You (Cosine Similarity)</p>
        <p class="text-purple-600 text-sm">Based on your rating profile, we found similar tools you might like.</p>
    </div>
</div>

<!-- Tools Grid -->
<?php if (!empty($tools)): ?>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    <?php foreach ($tools as $tool): ?>
    <a href="<?= base_url('tools/detail/'.$tool->tool_id) ?>" 
       class="group bg-white rounded-xl p-5 border border-slate-200 hover:border-purple-300 hover:shadow-lg transition-all">
        
        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-violet-600 rounded-lg flex items-center justify-center text-white text-sm font-bold mb-4">
            <?= strtoupper(substr($tool->company_name, 0, 1)) ?>
        </div>
        
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
            <span class="text-purple-500 text-sm opacity-0 group-hover:opacity-100 transition">
                View →
            </span>
        </div>
    </a>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="text-center py-20">
    <p class="text-5xl mb-4">🎯</p>
    <p class="text-slate-500 mb-6">Rate more tools to unlock better recommendations!</p>
    <a href="<?= base_url('tools') ?>" class="inline-block bg-slate-900 text-white px-6 py-3 rounded-full hover:bg-slate-700">
        Explore Tools
    </a>
</div>
<?php endif; ?>
