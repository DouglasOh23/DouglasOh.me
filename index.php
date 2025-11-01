<?php
declare(strict_types=1);

$resume = require __DIR__ . '/resume-data.php';

$basics = $resume['basics'] ?? [];
$seo = $resume['seo'] ?? [];
$links = is_array($basics['links'] ?? null) ? $basics['links'] : [];
$summary = $basics['summary'] ?? ($resume['summary'] ?? '');

$sanitizedPhone = '';
if (!empty($basics['phone'] ?? '')) {
    $sanitizedPhone = preg_replace('/[^\d+]/', '', (string) $basics['phone']);
    if (!is_string($sanitizedPhone)) {
        $sanitizedPhone = '';
    }
}

$formatRange = static function (?string $start, ?string $end): string {
    $start = trim((string) ($start ?? ''));
    $end = trim((string) ($end ?? ''));
    if ($start === '' && $end === '') {
        return '';
    }
    if ($start !== '' && $end === '') {
        $end = 'Present';
    }
    if ($start === '') {
        return $end;
    }
    if ($end === '') {
        return $start;
    }
    return $start . ' — ' . $end;
};

$structuredData = [
    '@context' => 'https://schema.org',
    '@type' => 'Person',
    'name' => $basics['name'] ?? '',
    'jobTitle' => $basics['title'] ?? '',
    'email' => !empty($basics['email'] ?? '') ? 'mailto:' . $basics['email'] : null,
    'telephone' => $sanitizedPhone !== '' ? $sanitizedPhone : null,
    'url' => $basics['website'] ?? null,
    'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => $basics['location'] ?? '',
    ],
];

if (!empty($resume['experience'][0]['company'] ?? '')) {
    $structuredData['worksFor'] = [
        '@type' => 'Organization',
        'name' => $resume['experience'][0]['company'],
    ];
}

if (!empty($links)) {
    $structuredData['sameAs'] = array_values(
        array_filter(
            array_map(
                static fn ($link) => $link['url'] ?? null,
                $links
            ),
            static fn ($url) => is_string($url) && $url !== ''
        )
    );
}

$structuredData['address'] = array_filter($structuredData['address']);
$structuredData = array_filter(
    $structuredData,
    static fn ($value) => !empty($value)
);

$structuredDataJson = '';
if (!empty($structuredData)) {
    $structuredDataJson = json_encode(
        $structuredData,
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    ) ?: '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($basics['name'] ?? 'Your Name'); ?> — <?= htmlspecialchars($basics['title'] ?? 'Professional Title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<?php if (!empty($seo['description'] ?? '')): ?>
    <meta name="description" content="<?= htmlspecialchars($seo['description']); ?>">
<?php endif; ?>
<?php if (!empty($seo['keywords'] ?? [])): ?>
    <meta name="keywords" content="<?= htmlspecialchars(implode(', ', $seo['keywords'])); ?>">
<?php endif; ?>
<?php if (!empty($seo['canonical'] ?? '')): ?>
    <link rel="canonical" href="<?= htmlspecialchars($seo['canonical']); ?>">
<?php endif; ?>
<?php if (!empty($seo['og_image'] ?? '')): ?>
    <meta property="og:image" content="<?= htmlspecialchars($seo['og_image']); ?>">
<?php endif; ?>
    <meta property="og:type" content="profile">
    <meta property="og:title" content="<?= htmlspecialchars($basics['name'] ?? 'Your Name'); ?>">
<?php if (!empty($seo['description'] ?? '')): ?>
    <meta property="og:description" content="<?= htmlspecialchars($seo['description']); ?>">
<?php endif; ?>
<?php if (!empty($seo['canonical'] ?? '')): ?>
    <meta property="og:url" content="<?= htmlspecialchars($seo['canonical']); ?>">
<?php endif; ?>
    <meta name="twitter:card" content="summary_large_image">
    <link rel="stylesheet" href="styles.css">
<?php if ($structuredDataJson !== ''): ?>
    <script type="application/ld+json">
<?= $structuredDataJson . PHP_EOL ?>
    </script>
<?php endif; ?>
</head>
<body>
    <div class="page">
        <button type="button" class="print-button" onclick="window.print()">Print / Save PDF</button>
        <header class="hero">
            <h1><?= htmlspecialchars($basics['name'] ?? 'Your Name'); ?></h1>
<?php if (!empty($basics['title'] ?? '')): ?>
            <p class="hero__title"><?= htmlspecialchars($basics['title']); ?></p>
<?php endif; ?>
            <ul class="hero__meta">
<?php if (!empty($basics['location'] ?? '')): ?>
                <li><?= htmlspecialchars($basics['location']); ?></li>
<?php endif; ?>
<?php if (!empty($basics['email'] ?? '')): ?>
                <li><a href="mailto:<?= htmlspecialchars($basics['email']); ?>"><?= htmlspecialchars($basics['email']); ?></a></li>
<?php endif; ?>
<?php if ($sanitizedPhone !== ''): ?>
                <li><a href="tel:<?= htmlspecialchars($sanitizedPhone); ?>"><?= htmlspecialchars($basics['phone'] ?? $sanitizedPhone); ?></a></li>
<?php endif; ?>
<?php if (!empty($basics['website'] ?? '')): ?>
                <li><a href="<?= htmlspecialchars($basics['website']); ?>"><?= htmlspecialchars($basics['website']); ?></a></li>
<?php endif; ?>
            </ul>
<?php if (!empty($links)): ?>
            <ul class="hero__links">
<?php foreach ($links as $link): ?>
<?php
    $label = $link['label'] ?? '';
    $url = $link['url'] ?? '';
    if ($label === '' || $url === '') {
        continue;
    }
?>
                <li><a href="<?= htmlspecialchars($url); ?>"><?= htmlspecialchars($label); ?></a></li>
<?php endforeach; ?>
            </ul>
<?php endif; ?>
<?php if (!empty($summary)): ?>
            <p class="hero__summary"><?= nl2br(htmlspecialchars($summary)); ?></p>
<?php endif; ?>
        </header>

        <main>
<?php if (!empty($resume['experience'] ?? [])): ?>
            <section class="section">
                <h2>Experience</h2>
<?php foreach ($resume['experience'] as $experience): ?>
                <article class="card">
                    <header>
                        <h3><?= htmlspecialchars($experience['role'] ?? 'Role'); ?></h3>
                        <p class="card__meta">
                            <span><?= htmlspecialchars($experience['company'] ?? 'Company'); ?></span>
<?php if (!empty($experience['location'] ?? '')): ?>
                            <span>• <?= htmlspecialchars($experience['location']); ?></span>
<?php endif; ?>
<?php
    $timeframe = $formatRange($experience['start'] ?? null, $experience['end'] ?? null);
    if ($timeframe !== ''):
?>
                            <span>• <?= htmlspecialchars($timeframe); ?></span>
<?php endif; ?>
                        </p>
                    </header>
<?php if (!empty($experience['summary'] ?? '')): ?>
                    <p class="card__summary"><?= htmlspecialchars($experience['summary']); ?></p>
<?php endif; ?>
<?php if (!empty($experience['highlights'] ?? [])): ?>
                    <ul class="card__list">
<?php foreach ($experience['highlights'] as $highlight): ?>
                        <li><?= htmlspecialchars($highlight); ?></li>
<?php endforeach; ?>
                    </ul>
<?php endif; ?>
                </article>
<?php endforeach; ?>
            </section>
<?php endif; ?>

<?php if (!empty($resume['projects'] ?? [])): ?>
            <section class="section">
                <h2>Projects</h2>
<?php foreach ($resume['projects'] as $project): ?>
                <article class="card">
                    <header>
                        <h3>
<?php if (!empty($project['link'] ?? '')): ?>
                            <a href="<?= htmlspecialchars($project['link']); ?>"><?= htmlspecialchars($project['name'] ?? 'Project'); ?></a>
<?php else: ?>
                            <?= htmlspecialchars($project['name'] ?? 'Project'); ?>
<?php endif; ?>
                        </h3>
<?php if (!empty($project['summary'] ?? '')): ?>
                        <p class="card__summary"><?= htmlspecialchars($project['summary']); ?></p>
<?php endif; ?>
                    </header>
<?php if (!empty($project['stack'] ?? [])): ?>
                    <p class="card__meta"><?= htmlspecialchars(implode(' • ', $project['stack'])); ?></p>
<?php endif; ?>
<?php if (!empty($project['highlights'] ?? [])): ?>
                    <ul class="card__list">
<?php foreach ($project['highlights'] as $highlight): ?>
                        <li><?= htmlspecialchars($highlight); ?></li>
<?php endforeach; ?>
                    </ul>
<?php endif; ?>
                </article>
<?php endforeach; ?>
            </section>
<?php endif; ?>

<?php if (!empty($resume['skills'] ?? [])): ?>
            <section class="section">
                <h2>Skills</h2>
                <div class="skills-grid">
<?php foreach ($resume['skills'] as $skillGroup): ?>
                    <div class="skills-grid__item">
                        <h3><?= htmlspecialchars($skillGroup['category'] ?? 'Skills'); ?></h3>
<?php if (!empty($skillGroup['items'] ?? [])): ?>
                        <p><?= htmlspecialchars(implode(' • ', $skillGroup['items'])); ?></p>
<?php endif; ?>
                    </div>
<?php endforeach; ?>
                </div>
            </section>
<?php endif; ?>

<?php if (!empty($resume['education'] ?? [])): ?>
            <section class="section">
                <h2>Education</h2>
<?php foreach ($resume['education'] as $education): ?>
                <article class="card">
                    <header>
                        <h3><?= htmlspecialchars($education['degree'] ?? 'Degree'); ?></h3>
                        <p class="card__meta">
                            <span><?= htmlspecialchars($education['institution'] ?? 'Institution'); ?></span>
<?php if (!empty($education['location'] ?? '')): ?>
                            <span>• <?= htmlspecialchars($education['location']); ?></span>
<?php endif; ?>
<?php
    $timeframe = $formatRange($education['start'] ?? null, $education['end'] ?? null);
    if ($timeframe !== ''):
?>
                            <span>• <?= htmlspecialchars($timeframe); ?></span>
<?php endif; ?>
                        </p>
                    </header>
<?php if (!empty($education['summary'] ?? '')): ?>
                    <p class="card__summary"><?= htmlspecialchars($education['summary']); ?></p>
<?php endif; ?>
<?php if (!empty($education['highlights'] ?? [])): ?>
                    <ul class="card__list">
<?php foreach ($education['highlights'] as $highlight): ?>
                        <li><?= htmlspecialchars($highlight); ?></li>
<?php endforeach; ?>
                    </ul>
<?php endif; ?>
                </article>
<?php endforeach; ?>
            </section>
<?php endif; ?>

<?php if (!empty($resume['awards'] ?? [])): ?>
            <section class="section">
                <h2>Awards & Recognition</h2>
<?php foreach ($resume['awards'] as $award): ?>
                <article class="card">
                    <header>
                        <h3><?= htmlspecialchars($award['title'] ?? 'Award'); ?></h3>
                        <p class="card__meta">
                            <span><?= htmlspecialchars($award['issuer'] ?? 'Issuer'); ?></span>
<?php if (!empty($award['year'] ?? '')): ?>
                            <span>• <?= htmlspecialchars($award['year']); ?></span>
<?php endif; ?>
                        </p>
                    </header>
<?php if (!empty($award['summary'] ?? '')): ?>
                    <p class="card__summary"><?= htmlspecialchars($award['summary']); ?></p>
<?php endif; ?>
                </article>
<?php endforeach; ?>
            </section>
<?php endif; ?>
        </main>

        <footer class="footer">
            <p>© <?= date('Y'); ?> <?= htmlspecialchars($basics['name'] ?? 'Your Name'); ?>. Crafted with PHP.</p>
        </footer>
    </div>
</body>
</html>

