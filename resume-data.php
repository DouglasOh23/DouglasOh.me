<?php

declare(strict_types=1);

/**
 * Update this file with your real resume content.
 * Duplicate the array structures and replace placeholder text with your data.
 */
return [
    'basics' => [
        'name' => 'Your Name',
        'pronouns' => 'they/them',
        'title' => 'Software Engineer',
        'location' => 'City, Country',
        'email' => 'you@example.com',
        'phone' => '+1 (555) 123-4567',
        'website' => 'https://example.com',
        'summary' => "Craft a two-to-three sentence summary that highlights your value proposition, domain focus, and standout achievements.",
        'links' => [
            ['label' => 'GitHub', 'url' => 'https://github.com/username'],
            ['label' => 'LinkedIn', 'url' => 'https://www.linkedin.com/in/username'],
            ['label' => 'Portfolio', 'url' => 'https://example.com/work'],
        ],
    ],
    'skills' => [
        [
            'category' => 'Languages',
            'items' => ['PHP', 'JavaScript', 'TypeScript', 'Python'],
        ],
        [
            'category' => 'Frameworks',
            'items' => ['Laravel', 'React', 'Node.js', 'Symfony'],
        ],
        [
            'category' => 'Tools',
            'items' => ['Docker', 'MySQL', 'GitHub Actions', 'AWS'],
        ],
    ],
    'experience' => [
        [
            'role' => 'Senior Software Engineer',
            'company' => 'Acme Corp',
            'location' => 'Remote',
            'start' => '2021',
            'end' => 'Present',
            'summary' => 'Briefly describe your mission or scope in this role.',
            'highlights' => [
                'Led a cross-functional initiative that increased conversion by 18% for flagship product.',
                'Designed and shipped a multi-tenant platform used by 200+ enterprise customers.',
                'Mentored 4 engineers and introduced a PHP architecture guild to strengthen best practices.',
            ],
        ],
        [
            'role' => 'Software Engineer',
            'company' => 'Globex',
            'location' => 'Toronto, Canada',
            'start' => '2018',
            'end' => '2021',
            'summary' => 'Optional paragraph for additional context around your responsibilities.',
            'highlights' => [
                'Delivered reporting suite with automated insights that reduced manual analysis time by 60%.',
                'Collaborated with design to overhaul onboarding, lowering drop-off by 23%.',
            ],
        ],
    ],
    'projects' => [
        [
            'name' => 'Project Atlas',
            'role' => 'Creator',
            'link' => 'https://github.com/username/project-atlas',
            'summary' => 'Open-source toolkit that scaffolds modern PHP APIs in under two minutes.',
            'stack' => ['PHP', 'Slim', 'MariaDB', 'Docker'],
            'highlights' => [
                'Implemented plug-and-play modules for auth, logging, and observability.',
                'Reached 1,500+ GitHub stars and adopted by several tech bootcamps.',
            ],
        ],
        [
            'name' => 'Realtime Ops Dashboard',
            'role' => 'Lead Developer',
            'link' => 'https://example.com/realtime-ops',
            'summary' => 'Command centre dashboard powering live operations for logistics teams.',
            'stack' => ['React', 'Node.js', 'PostgreSQL', 'AWS'],
            'highlights' => [
                'Architected event-driven pipeline handling over 2M updates daily.',
                'Built analytics layer enabling 30% faster response times for dispatchers.',
            ],
        ],
    ],
    'education' => [
        [
            'degree' => 'B.Sc. Computer Science',
            'institution' => 'University of Somewhere',
            'location' => 'City, Country',
            'start' => '2014',
            'end' => '2018',
            'summary' => 'Graduated magna cum laude with focus on distributed systems and human-computer interaction.',
            'highlights' => [
                'Dean\'s List (2016-2018)',
                'Capstone project selected for university tech showcase.',
            ],
        ],
    ],
    'awards' => [
        [
            'title' => 'Innovation Award',
            'issuer' => 'Tech Conference XYZ',
            'year' => '2022',
            'summary' => 'Recognized for leading development of AI-assisted developer tooling.',
        ],
    ],
    'seo' => [
        'description' => 'Personal resume site for Your Name, a software engineer focused on shipping measurable impact.',
        'keywords' => ['Software Engineer', 'PHP Developer', 'Resume'],
        'canonical' => 'https://example.com',
        'og_image' => 'https://example.com/og-image.jpg',
    ],
];
