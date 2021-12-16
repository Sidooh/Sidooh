<?php

namespace App\Helpers\Statistics;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;

class ChartAid
{
    private mixed $aggregateType;
    /**
     * @var mixed|null
     */
    private mixed $aggregateColumn;
    /**
     * @var mixed|string
     */
    private string $frequency;
    private Collection $models;

    //  Aggregate Types - count, sum
    public function __construct(Frequency $frequency, string $aggregateType = 'count', string $aggregateColumn = null) {
        $this->frequency = $frequency->value;
        $this->aggregateType = $aggregateType;
        $this->aggregateColumn = $aggregateColumn;
    }


    /**
     * @param Collection $models
     * @return array
     */
    #[ArrayShape(['labels' => "array", 'datasets' => "array"])]
    public function chartDataSet(Collection $models): array {
        $this->models = $models;

        $freqCount = match ($this->frequency) {
            'yearly', 'daily' => 12,
            'weekly' => 4,
            'monthly' => 3,
            default => 7
        };

        $date = new Carbon;

        $data = collect();
        for($i = 0; $i < $freqCount; $i++) {
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

    public function parseCarbonDate($time): Carbon {
        return match ($this->frequency) {
            'weekly' => Carbon::now()->setISODate(now()->year, $time),
            'yearly' => Carbon::createFromDate($time),
            'daily' => Carbon::createFromTime($time),
            default => Carbon::parse($time)
        };
    }

    public function getLabelName(Carbon $date): int|string {
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
                $name = 'Within the hour';
            } else if($date->isLastHour()) {
                $name = 'An hour ago';
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
        return match ($this->frequency) {
            'yearly' => Carbon::parse($date)->format('Y'),
            'monthly' => Carbon::parse($date)->format('Y-m'),
            'weekly' => Carbon::parse($date)->format('W'),
            'daily' => Carbon::parse($date)->format('H'),
            default => Carbon::parse($date)->toDateString()
        };
    }

    public function chartStartDate(): Carbon {
        return match ($this->frequency) {
            'yearly' => now()->subYear(),
            'monthly' => now()->subMonths(3),
            'weekly' => now()->subWeeks(4),
            'daily' => now()->startOfDay(),
            default => now()->subWeek()
        };
    }
}
