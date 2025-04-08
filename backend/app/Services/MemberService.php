<?php
namespace App\Services;


use Illuminate\Http\Request;

class MemberService implements MemberServiceInterface
{
    /**
     * @param Request $request
     * @return array
     */
    public function findFurthest(Request $request): array
    {
        try {
            $numberMember = $request->get('numberMember', 4);
            $numberPerCent = $request->get('numberPercent', 10);
            $members = $this->generateMembers($numberMember);
            $totalMembers = 0;
            while (isset($members[$totalMembers])) {
                $totalMembers++;
            }
            $distances = [];

            for ($i = 0; $i < $totalMembers; $i ++) {
                $sumDistance = 0;
                for ($j = 0; $j < $totalMembers; $j ++) {
                    if ($i != $j) {
                        $sumDistance += $this->getDistance($members[$i], $members[$j]);
                    }
                }
                $distances[] = [
                    'index' => $i,
                    'position' => $members[$i],
                    'average_distance' => $sumDistance,
                ];
            }
            $distances = $this->sortDistanceDown($distances, $totalMembers);
            $result = $this->getMemberByPercent($distances, $numberPerCent, $totalMembers);
            return [
                "topMember" => $result,
                "members" => $members
            ];
        } catch (\Exception $e) {
            return [
                "message" => "Program error!" . $e->getMessage(),
            ];
        }
    }

    /**
     * @param array $members
     * @param int $percent
     * @param int $totalMembers
     * @return array
     */
    private function getMemberByPercent(array $members, int $percent, int $totalMembers): array
    {
        $top_n_float = ($totalMembers * $percent) / 100;
        $top_n = (int) $top_n_float;
        if ($top_n_float > $top_n) {
            $top_n += 1;
        }
        if ($top_n < 1) {
            $top_n = 1;
        }

        $result = [];
        $index = 0;
        while ($index < $top_n && isset($members[$index])) {
            $result[$index] = $members[$index];
            $index++;
        }
        return $result;
    }

    /**
     * @param array $distances
     * @param int $totalMembers
     * @return array $distances
     */
    private function sortDistanceDown(array $distances, int $totalMembers): array
    {
        for ($i = 0; $i < $totalMembers - 1; $i++) {
            for ($j = 0; $j < $totalMembers - $i - 1; $j++) {
                if ($distances[$j]['average_distance'] < $distances[$j + 1]['average_distance']) {
                    $temp = $distances[$j];
                    $distances[$j] = $distances[$j + 1];
                    $distances[$j + 1] = $temp;
                }
            }
        }
        return $distances;
    }

    /**
     * @param $distance1
     * @param $distance2
     * @return int
     */
    private function getDistance($distance1, $distance2): int
    {
        return (int) sqrt(pow($distance1[0] - $distance2[0], 2) + pow($distance1[1] - $distance2[1], 2));
    }

    /**
     * @param int $numberMember
     * @return array
     */
    private function generateMembers(int $numberMember): array
    {
        $members = [];
        for ($i = 0; $i < $numberMember; $i++) {
            $members[] = [
                rand(-10, 10), rand(-10, 10)
            ];
        }
        return $members;
    }
}
