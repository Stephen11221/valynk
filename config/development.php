<?php

return [
    'plans' => ['Individual' => 1500, 'Family' => 2500, 'Provider' => 3500, 'Institution' => 7500],
    'questions' => [
        1 => [
            'reasons' => ['What are your main reasons for seeking support?', 'multi', ['Academic Performance', 'Confidence & Self-Esteem', 'Focus & Attention', 'Emotional Wellbeing', 'Behaviour & Discipline', 'Social Skills & Relationships', 'Career Guidance', 'Other']],
            'performance' => ['How would you describe your child’s current performance?', 'radio', ['Excelling', 'Doing well', 'Average', 'Struggling', 'Not sure']],
            'goals' => ['What are your top 3 goals for the next 12 months?', 'goals', ['Improve grades and learning habits', 'Build confidence and self-belief', 'Develop key skills', 'Explore career interests', 'Improve behaviour', 'Better emotional resilience', 'Gain exposure to opportunities', 'Other']],
        ],
        2 => [
            'learning' => ['How does your child prefer to learn?', 'multi', ['Visual', 'Auditory', 'Hands-on', 'Reading & Writing', 'Mixture of styles', 'Not sure yet']],
            'differences' => ['Does your child have diagnosed or suspected learning differences?', 'radio', ['No', 'Yes', 'Not sure']],
            'difference_details' => ['If yes, please specify (optional)', 'text', []],
            'disability' => ['Does your child have a disability or special need?', 'radio', ['No', 'Yes', 'Not sure']],
            'disability_details' => ['If yes, please specify (optional)', 'text', []],
            'emotional' => ['How would you describe your child’s emotional wellbeing?', 'radio', ['Very good', 'Good', 'Average', 'Needs support', 'Not sure']],
            'social' => ['How would you describe your child’s social behaviour?', 'radio', ['Very good', 'Good', 'Average', 'Needs support', 'Not sure']],
            'notes' => ['Anything else you would like to share? (optional)', 'text', []],
        ],
        3 => [
            'support' => ['Which areas would you like support for?', 'multi', ['Academic Support', 'Confidence & Self-Esteem', 'Focus & Concentration', 'Behaviour & Discipline', 'Emotional Wellbeing', 'Social Skills & Relationships', 'Career Guidance', 'Life Skills', 'Other']],
            'heard' => ['How did you hear about VALYNK?', 'radio', ['School/Teacher', 'Friend or Family', 'Social Media', 'Partner Organisation', 'Search Engine', 'Other']],
            'expectations' => ['What are your expectations from VALYNK? (optional)', 'text', []],
            'updates' => ['Would you like to receive parent resources and updates?', 'radio', ['Yes', 'No']],
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
