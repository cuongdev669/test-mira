<?php

namespace App\Services;


use Illuminate\Http\Request;
use staabm\SideEffectsDetector\SideEffect;

class StudentStatService implements StudentStatServiceInterface
{
    /**
     *
     * @param Request $request
     * @return array
     */
    public function calculateStats(Request $request): array
    {
        try {
            $avgYear = $request->get('avgYear', 20);
            $avgMonth = $request->get('avgMonth', 8);
            $averageAge =  round(($avgYear + $avgMonth/12), 2); // 20.67
            $thresholdAbove = round($averageAge + 0.5, 2); // 21.17
            $thresholdBelow = round($averageAge - 0.5, 2); // 20.17

            $classes = $this->generateClass($averageAge);
            $result = [];

            foreach ($classes as $class => $classDetail) {
                $students = $classDetail['students'];
                $older = count(array_filter($students, function($age) use ($thresholdAbove) {
                    return $age > $thresholdAbove;
                }));

                $younger = count(array_filter($students, function($age) use ($thresholdBelow) {
                    return $age < $thresholdBelow;
                }));

                $result[] = [
                    'class_name' => $class,
                    'older_than_average_6_months' => $older,
                    'younger_than_average_6_months' => $younger,
                ];
            }

            return $result;
        } catch (\Exception $e) {
            return [
                'message' => 'Program error!' . $e->getMessage()
            ];
        }
    }

    /**
     * @return array|array[]
     */
    private function generateClass($averageAge): array
    {
        $classes = [
            'Class A' => [
                'total' => 35,
                'students' => []
            ],
            'Class B' => [
                'total' => 35,
                'students' => []
            ],
            'Class C' => [
                'total' => 35,
                'students' => []
            ],
            'Class D' => [
                'total' => 35,
                'students' => []
            ],
            'Class E' => [
                'total' => 35,
                'students' => []
            ], // 5 class have 35 students
            'Class F' => [
                'total' => 45,
                'students' => []
            ],
            'Class G' => [
                'total' => 45,
                'students' => []
            ],
            'Class H' => [
                'total' => 45,
                'students' => []
            ],
            'Class I' => [
                'total' => 45,
                'students' => []
            ],
            'Class J' => [
                'total' => 45,
                'students' => []
            ],
            'Class K' => [
                'total' => 45,
                'students' => []
            ], // 6 classes have 45 students
            'Class L' => [
                'total' => 30,
                'students' => []
            ],
            'Class M' => [
                'total' => 30,
                'students' => []
            ],
            'Class N' => [
                'total' => 30,
                'students' => []
            ],
            'Class O' => [
                'total' => 30,
                'students' => []
            ],
            'Class P' => [
                'total' => 30,
                'students' => []
            ],
            'Class Q' => [
                'total' => 30,
                'students' => []
            ],
            'Class R' => [
                'total' => 30,
                'students' => []
            ],
            'Class S' => [
                'total' => 30,
                'students' => []
            ],
            'Class T' => [
                'total' => 30,
                'students' => []
            ],
            'Class U' => [
                'total' => 30,
                'students' => []
            ], // 10 classes have 30 students
            'Class A1' => [
                'total' => 35,
                'students' => []
            ],
            'Class B1' => [
                'total' => 35,
                'students' => []
            ],
            'Class C1' => [
                'total' => 35,
                'students' => []
            ],
            'Class D1' => [
                'total' => 35,
                'students' => []
            ], // 4 classes have 40 students
        ];

        $totalStudents = 0;
        foreach ($classes as $class => $detail) {
            $totalStudents += $detail['total'];
        }

        $totalAgeTarget = $totalStudents * $averageAge;

        $ages = $this->generateAges($totalStudents, $totalAgeTarget);

        $index = 0;
        foreach ($classes as $class => $detail) {
            for ($i = 0; $i < $detail['total']; $i++) {
                $classes[$class]['students'][] = $ages[$index++];
            }
        }
        return $classes;
    }

    /**
     * @param $count
     * @param $targetSum
     * @return array
     */
    private function generateAges($count, $targetSum): array
    {
        $ages = [];

        for ($i = 0; $i < $count; $i++) {
            $age = 20.67 + mt_rand(-60, 60) / 100; // random from 20.07 ~ 21.27.
            $age = intval($age * 100 + 0.5) / 100; // Round to 2 decimal places

            $ages[] = $age;
        }

        // Array sum
        $currentSum = 0;
        for ($i = 0; $i < $count; $i++) {
            $currentSum += $ages[$i];
        }

        $diff = $targetSum - $currentSum;

        // Round to 2 decimal places
        $diff = intval($diff * 100 + 0.5) / 100;

        // Call adjust per student
        $adjustPerStudent = $diff / $count;
        $adjustPerStudent = intval($adjustPerStudent * 10000 + 0.5) / 10000;

        // Add adjust
        for ($i = 0; $i < $count; $i++) {
            $ages[$i] += $adjustPerStudent;
            $ages[$i] = intval($ages[$i] * 100 + 0.5) / 100;
        }

        return $ages;
    }
}
