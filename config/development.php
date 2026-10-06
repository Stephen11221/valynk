<?php

return [
    'connection' => [
        'reasons' => [
            'Build confidence and self-belief',
            'Improve focus and study habits',
            'Set goals and stay motivated',
            'Manage stress and handle challenges',
            'Improve social skills and relationships',
            'Develop discipline and consistent habits',
        ],
        'levels' => ['Very low', 'Low', 'Moderate', 'High', 'Very high'],
        'timelines' => ['As soon as possible (within 1 month)', 'In 1–3 months', 'In 3–6 months', 'Just exploring for now'],
    ],
    'assessment_icons' => [
        'reasons' => ['book-open', 'people-group', 'brain', 'heart', 'dumbbell', 'users', 'compass', 'ellipsis'],
        'goals' => ['bullseye', 'person-rays', 'chart-column', 'lightbulb', 'user-group', 'heart', 'star', 'ellipsis'],
    ],
    'report_subscriptions' => ['monthly' => ['name' => 'Monthly Access', 'fee' => 1500, 'period' => 'per month', 'days' => 30], 'three-month' => ['name' => '3-Month Access', 'fee' => 3500, 'period' => 'for 3 months', 'days' => 90]],
    'plans' => ['Individual' => 1500, 'Family' => 2500, 'Provider' => 3500, 'Institution' => 7500],
    'mindset_questions' => [
        1 => [
            'key' => 'confidence', 'area' => 'Positive Belief & Winning Mindset', 'icon' => 'brain',
            'label' => 'How would you describe your child’s confidence when facing new challenges?',
            'help' => 'This helps us understand your child’s self-belief when facing something new.',
            'options' => [
                'Very confident' => 'My child usually tries new things and believes they can do it.',
                'Somewhat confident' => 'My child is confident sometimes, but can be unsure in new situations.',
                'Not very confident' => 'My child often doubts themselves or is afraid to try new things.',
                'I’m not sure' => 'It depends / I need more time to observe.',
            ],
        ],
        2 => [
            'key' => 'resilience', 'area' => 'Positive Belief & Winning Mindset', 'icon' => 'brain',
            'label' => 'How does your child usually react when they make a mistake?',
            'help' => 'This helps us understand how your child handles challenges, so we can recommend support that builds resilience and a growth mindset.',
            'options' => [
                'They stay positive and try again.' => 'They learn from the mistake and keep going.',
                'They feel disappointed but try again.' => 'They may feel bad at first, but usually keep going.',
                'They get upset and find it hard to continue.' => 'They often lose confidence when things don’t go well.',
                'They avoid trying or give up easily.' => 'They are afraid of making mistakes.',
            ],
        ],
        3 => [
            'key' => 'focus', 'area' => 'Focus and Discipline', 'icon' => 'bullseye',
            'label' => 'How easily can your child stay focused on a task (e.g. schoolwork or reading)?',
            'help' => 'Focus and discipline help your child complete schoolwork, manage time, and build good habits — important skills for academic success and life growth.',
            'options' => [
                'Very easily' => 'They can usually stay focused for a long time without getting distracted.',
                'Somewhat easily' => 'They can stay focused, but sometimes get distracted.',
                'Not very easily' => 'They often get distracted and find it hard to stay focused.',
                'Not easily at all' => 'They find it very difficult to stay focused, even for short periods.',
            ],
        ],
        4 => [
            'key' => 'routines', 'area' => 'Focus and Discipline', 'icon' => 'bullseye',
            'label' => 'How consistently does your child follow routines and complete tasks?',
            'help' => 'Consistent routines can help children build independence and follow through on their responsibilities.',
            'options' => [
                'Very consistently' => 'They usually follow routines and finish tasks independently.',
                'Somewhat consistently' => 'They manage most tasks with a few reminders.',
                'Not very consistently' => 'They need frequent reminders to stay on track.',
                'I’m not sure' => 'I need more time to observe their habits.',
            ],
        ],
        5 => [
            'key' => 'motivation', 'area' => 'Motivation and Purpose', 'icon' => 'flag',
            'label' => 'How motivated is your child to learn and work towards something important to them?',
            'help' => 'Understanding what motivates your child helps us recommend support that connects with their interests.',
            'options' => [
                'Very motivated' => 'They show interest and keep working towards what matters to them.',
                'Somewhat motivated' => 'They show interest but sometimes need encouragement.',
                'Not very motivated' => 'They often find it difficult to get started or keep going.',
                'I’m not sure' => 'Their motivation varies / I need more time to observe.',
            ],
        ],
        6 => [
            'key' => 'goals', 'area' => 'Motivation and Purpose', 'icon' => 'flag',
            'label' => 'How clearly can your child identify a goal and take steps towards achieving it?',
            'help' => 'Small, meaningful goals can help your child develop a sense of purpose and recognise their progress.',
            'options' => [
                'Very clearly' => 'They can set a goal and take practical steps towards it.',
                'Somewhat clearly' => 'They have ideas but need help planning the next steps.',
                'Not very clearly' => 'They find it difficult to decide what to aim for.',
                'I’m not sure' => 'We have not explored goals together yet.',
            ],
        ],
    ],
    'questions' => [
        1 => [
            'reasons' => ['What are your main reasons for seeking support?', 'multi', ['Academic Performance', 'Confidence & Self-Esteem', 'Focus & Attention', 'Emotional Wellbeing', 'Behaviour & Discipline', 'Social Skills & Relationships', 'Career Guidance', 'Other']],
            'performance' => ['How would you describe your child’s current performance?', 'radio', ['Excelling', 'Doing well', 'Average', 'Struggling', 'Not sure']],
            'goals' => ['What are your top 3 goals for the next 12 months?', 'goals', ['Improve grades and learning habits', 'Build confidence and self-belief', 'Develop key skills', 'Explore career interests', 'Improve behaviour', 'Better emotional resilience', 'Gain exposure to opportunities', 'Other']],
        ],
        2 => [
            'learning' => ['How does your child prefer to learn?', 'multi', ['Visual', 'Auditory', 'Hands-on', 'Reading & Writing', 'Mixture of styles', 'Not sure yet']],
            'differences' => ['Does your child have any diagnosed or suspected learning differences?', 'radio', ['No', 'Yes', 'Not sure']],
            'difference_details' => ['If yes, please specify (optional)', 'text', []],
            'disability' => ['Please indicate if your child has a disability or special need (PWD status).', 'radio', ['No', 'Yes', 'Not sure']],
            'disability_details' => ['If yes, please specify (optional)', 'text', []],
            'emotional' => ['How would you describe your child’s current emotional wellbeing?', 'radio', ['Very good', 'Good', 'Average', 'Needs support', 'Not sure']],
            'social' => ['How would you describe your child’s social behaviour?', 'radio', ['Very good', 'Good', 'Average', 'Needs support', 'Not sure']],
            'notes' => ['Any additional information you would like to share? (Optional)', 'text', []],
        ],
        3 => [
            'support' => ['Which areas would you like support for?', 'multi', ['Academic Support', 'Confidence & Self-Esteem', 'Focus & Concentration', 'Behaviour & Discipline', 'Emotional Wellbeing', 'Social Skills & Relationships', 'Career Guidance', 'Life Skills', 'Other']],
            'heard' => ['How did you hear about VALYNK?', 'radio', ['School/Teacher', 'Friend or Family', 'Social Media', 'Partner Organisation', 'Search Engine', 'Other']],
            'expectations' => ['What are your expectations from VALYNK? (optional)', 'text', []],
            'updates' => ['Would you like to receive updates, tips and resources for parents?', 'radio', ['Yes', 'No']],
            'differences' => ['Does your child have any diagnosed or suspected learning differences?', 'radio', ['No', 'Yes', 'Not sure']],
            'difference_details' => ['If yes, please specify (optional)', 'text', []],
        ],
        4 => [
            'education' => ['What is your child’s current education level?', 'radio', ['Early Years (5–6)', 'Primary (7–12)', 'Junior Secondary (13–15)', 'Senior Secondary (16–18)', 'Young Adulthood (19–25)']],
            'environment' => ['What is your child’s learning environment?', 'radio', ['Day School', 'Boarding School', 'Homeschooling', 'Other']],
            'health' => ['Any health conditions or disabilities we should be aware of?', 'multi', ['None', 'Physical Disability', 'Visual Impairment', 'Hearing Impairment', 'Neurodivergent', 'Chronic Illness', 'Learning Difference', 'Other']],
            'challenges' => ['What are the main challenges your child experiences?', 'multi', ['Focus & Concentration', 'Confidence & Self-Esteem', 'Academic Performance', 'Behaviour & Discipline', 'Emotional Wellbeing', 'Social Skills & Relationships', 'Time Management', 'Other', 'None']],
            'additional' => ['Additional information that may help us support your child (optional)', 'text', []],
        ],
    ],
    'programmes' => [
        'pap' => ['name' => 'Performance Accelerator Program (PAP)', 'ages' => '11–18', 'min' => 11, 'max' => 18, 'days' => '5 days', 'date' => '9–13 Nov 2026', 'start' => '2026-11-09', 'end' => '2026-11-13', 'fee' => 29900, 'online' => 14900, 'image' => 'student', 'description' => 'Build mindset, focus, confidence and high-performance habits for academic and life success.'],
        'gap' => ['name' => 'Genius Activator Program (GAP)', 'ages' => '5–10', 'min' => 5, 'max' => 10, 'days' => '2 days', 'date' => '9–10 Nov 2026', 'start' => '2026-11-09', 'end' => '2026-11-10', 'fee' => 14900, 'online' => null, 'image' => 'family', 'description' => 'Activate creativity, focus and learning potential through fun, hands-on activities.'],
        'candidates' => ['name' => 'Candidates Program', 'ages' => '14–18', 'min' => 14, 'max' => 18, 'days' => '5 days', 'date' => '16–20 Nov 2026', 'start' => '2026-11-16', 'end' => '2026-11-20', 'fee' => 29900, 'online' => null, 'image' => 'student', 'description' => 'Build exam confidence, focus, resilience and peak performance.'],
        'club' => ['name' => 'PEAK Club (Termly)', 'ages' => '6–18', 'min' => 6, 'max' => 18, 'days' => 'Termly', 'date' => 'Jan–Mar 2027', 'start' => '2027-01-11', 'end' => '2027-03-26', 'fee' => 5000, 'online' => null, 'image' => 'family', 'description' => 'Sustain mindset and life skills with ongoing school-based sessions.'],
    ],
];
