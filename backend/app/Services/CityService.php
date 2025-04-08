<?php
namespace App\Services;

use Illuminate\Http\Request;

class CityService implements CityServiceInterface
{
    /**
     * @param Request $request
     * @return array
     */
    public function findMemberLargestAge(Request $request): array
    {
        try {
            $numberMember = $request->get('numberMember') ?? 100;
            $numberPercent = $request->get('numberPercent') ?? 10;
            $members = $this->generateMembers($numberMember);

            $membersSorted = $this->arrayBubbleSort($members, $numberMember);
            $result = $this->getTopPercentFurthestPeople($membersSorted, $numberPercent, $numberMember);
            return [
                "result" => $result,
                "members" => $members,
            ];
        } catch (\Exception $e) {
            return [
                "message" => "Program error!". $e->getMessage(),
            ];
        }
    }

    /**
     * @param array $membersSorted
     * @param int $numberPercent
     * @return array
     */
    private function getTopPercentFurthestPeople(array $membersSorted, int $numberPercent, int $numberMember): array
    {
        $numberMemberSelect = ($numberPercent * $numberMember) / 100;

        if ((int)$numberMemberSelect != $numberMemberSelect) {
            $numberMemberSelect = (int)$numberMemberSelect + 1;
        }

        if ($numberMemberSelect < 1) {
            $numberMemberSelect = 1;
        }

        $result = [];
        $i = 0;
        while ($i < $numberMemberSelect && isset($membersSorted[$i])) {
            $result[$i] = $membersSorted[$i];
            $i++;
        }

        return $result;
    }

    /**
     * @param array $array
     * @param int $totalArray
     * @return array
     */
    private function arrayBubbleSort(array $array, int $totalArray): array
    {
        for ($i = 0; $i < $totalArray - 1; $i ++) {
            for ($j = 0; $j < $totalArray - $i - 1; $j ++ ) {
                if ($array[$j]['age'] < $array[$j + 1]['age']) {
                    $temp = $array[$j];
                    $array[$j] = $array[$j + 1];
                    $array[$j + 1] = $temp;
                }
            }
        }
        return $array;
    }
    /**
     * @param int $numberMember
     * @return array
     */
    private function generateMembers(int $numberMember): array
    {
        $result = [];
        $index = 0;
        while ($index < $numberMember) {
            $result[] = [
                "name" => "Name" . ($index + 1),
                "age" => rand(1, 100)
            ];
            $index ++;
        }
        return $result;
    }
}
