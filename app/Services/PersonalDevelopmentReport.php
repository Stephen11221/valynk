<?php

namespace App\Services;

use App\Models\DevelopmentAssessment;

class PersonalDevelopmentReport
{
    /**
     * @return array{strengths: list<array<string, mixed>>, development: list<array<string, mixed>>, recommendations: list<string>, observations: list<array<string, mixed>>}
     */
    public function build(DevelopmentAssessment $assessment): array
    {
        $titles = ['confidence' => 'Self-Confidence', 'resilience' => 'Positive Mindset', 'focus' => 'Focus & Discipline', 'routines' => 'Consistency', 'motivation' => 'Motivation & Purpose', 'goals' => 'Goal Setting'];
        $recommendations = ['confidence' => 'Build self-confidence through small, achievable challenges.', 'resilience' => 'Practise learning from mistakes and trying again.', 'focus' => 'Build stronger study habits with short, focused tasks.', 'routines' => 'Create a consistent routine and celebrate follow-through.', 'motivation' => 'Connect learning activities with your child’s interests.', 'goals' => 'Set one meaningful goal and plan manageable next steps.'];
        $observations = [];
        foreach (config('development.mindset_questions') as $question) {
            $answer = data_get($assessment->answers, 'personal_development.'.$question['key']);
            $index = array_search($answer, array_keys($question['options']), true);
            if ($index === false) {
                continue;
            }
            $uncertain = str_contains($answer, 'not sure');
            $observations[] = [
                'key' => $question['key'], 'area' => $question['area'], 'title' => $titles[$question['key']], 'icon' => $question['icon'],
                'question' => $question['label'], 'answer' => $answer, 'description' => $question['options'][$answer],
                'strength' => ! $uncertain && $index <= 1, 'development' => $uncertain || $index >= 1,
                'priority' => $uncertain ? 1 : $index,
                'recommendation' => $uncertain ? 'Explore '.strtolower($titles[$question['key']]).' together and observe what support helps.' : $recommendations[$question['key']],
            ];
        }
        $strengths = [];
        $development = [];
        foreach ($observations as $item) {
            if ($item['strength']) {
                $strengths[$item['area']] ??= $item;
            }
            if ($item['development'] && (! isset($development[$item['area']]) || $item['priority'] > $development[$item['area']]['priority'])) {
                $development[$item['area']] = $item;
            }
        }
        $priorities = $observations;
        usort($priorities, fn (array $first, array $second): int => $second['priority'] <=> $first['priority']);

        return [
            'strengths' => array_values($strengths),
            'development' => array_values($development),
            'recommendations' => array_column(array_slice($priorities, 0, 3), 'recommendation'),
            'observations' => $observations,
        ];
    }
}
