<?php

namespace App\Helpers\Statistics;

use Carbon\CarbonImmutable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;

class ChartAid
{
    /**
     * @var mixed|string
     */
    private string $frequency;
    private Collection $models;
    private CarbonImmutable $CARBON;

    public function __construct(Frequency $frequency, private string $aggregateType = 'count', private ?string $aggregateColumn = null) {
        $this->frequency = $frequency->value;

        $this->CARBON = new CarbonImmutable(tz: 'Africa/Nairobi');
    }


    /**
     * @param Collection $models
     * @param null       $frequencyCount
     * @return array
     */
    #[ArrayShape(['labels' => "array", 'datasets' => "array"])]
    public function chartDataSet(Collection $models, $frequencyCount = null): array {
        $this->models = $models;

        if(is_null($frequencyCount)) {
            $frequencyCount = match ($this->frequency) {
                'yearly', 'daily' => 12,
                'weekly' => 4,
                'monthly' => 3,
                default => 7
            };
        }

        $date = new Carbon;

        $data = collect();
        for($i = 0; $i < $frequencyCount; $i++) {
            $dateString = self::chartDateFormat($date);

            $data[$dateString] = $this->aggregate($dateString);

            switch($this->frequency) {
                case 'daily':
                    $date->subHour();
                    break;
                case 'weekly':
                    $date->subWeek();
                    break;
                case 'yearly':
                case 'monthly':
                    $date->subMonth();
                    break;
                default:
                    $date->subDay();
            }
        }

        $data = $data->sortKeys();

        foreach($data as $key => $value) {
            $date = self::parseCarbonDate($key);

            $name = self::getLabelName($date);

            $data[$name] = $value;
            $data->forget($key);
        }

        return [
            'labels'   => $data->keys()->toArray(),
            'datasets' => $data->values()->toArray()
        ];
    }

    public function aggregate($dateString): int {
        return match ($this->aggregateType) {
            'sum' => isset($this->models[$dateString])
                ? $this->models[$dateString]->sum($this->aggregateColumn)
                : 0,
            default => isset($this->models[$dateString])
                ? $this->models[$dateString]->count()
                : 0,
        };
    }

    public function parseCarbonDate($time): Carbon|CarbonImmutable {
        return match ($this->frequency) {
            'weekly' => Carbon::now()->setISODate(now()->year, $time),
            'yearly' => Carbon::createFromDate($time, tz: 'Africa/Nairobi'),
            'daily' => Carbon::createFromTime($time, tz: 'Africa/Nairobi'),
            default => Carbon::parse($time, 'Africa/Nairobi')
        };
    }

    public function getLabelName(Carbon|CarbonImmutable $date): int|string {
        if($this->frequency === 'yearly') {
            if($date->isCurrentYear()) {
                $name = 'This year';
            } else if($date->isLastYear()) {
                $name = 'Last year';
            } else {
                $name = $date->year;
            }
        } else if($this->frequency === 'monthly') {
            if($date->isCurrentMonth()) {
                $name = 'This month';
            } else if($date->isLastMonth()) {
                $name = 'Last month';
            } else {
                $name = $date->shortMonthName;
            }
        } else if($this->frequency === 'weekly') {
            if($date->isCurrentWeek()) {
                $name = 'This week';
            } else if($date->isLastWeek()) {
                $name = 'Last week';
            } else {
                $name = "{$date->diffInWeeks()} week" . ($date->diffInWeeks() > 1
                        ? 's'
                        : '') . " ago";
            }
        } else if($this->frequency === 'daily') {
            if($date->isCurrentHour()) {
                $name = 'Current hour';
            } else if($date->isLastHour()) {
                $name = 'Last hour';
            } else {
                $name = $date->format('Hi \h\r\s');
            }
        } else {
            if($date->isCurrentDay()) {
                $name = 'Today';
            } else if($date->isYesterday()) {
                $name = 'Yesterday';
            } else {
                $name = $date->shortDayName;
            }
        }

        return $name;
    }


    /** chart   */
    public function chartDateFormat($date): string {
        $carbonDate = Carbon::parse($date)->timezone('Africa/Nairobi');

        return match ($this->frequency) {
            'yearly' => $carbonDate->format('Y'),
            'monthly' => $carbonDate->format('Y-m'),
            'weekly' => $carbonDate->format('W'),
            'daily' => $carbonDate->format('H'),
            default => $carbonDate->toDateString()
        };
    }

    public function chartStartDate(): Carbon|CarbonImmutable {
        $carbonDate = now('Africa/Nairobi');

        return match ($this->frequency) {
            'yearly' => $carbonDate->subYear(),
            'monthly' => $carbonDate->subMonths(3),
            'weekly' => $carbonDate->subWeeks(4),
            'daily' => $carbonDate->startOfDay(),
            default => $carbonDate->subWeek()
        };
    }
}
