<?php

namespace Tests\Unit\Enums;

use App\Enums\JobStatus;
use PHPUnit\Framework\TestCase;

class JobStatusTest extends TestCase
{
    /**
     * @test
     * @dataProvider getJobStatusEnum
     */
    public function shouldReturnActiveWhenForDisplay(JobStatus $status)
    {
        if ($status !== JobStatus::ToPriced) {
            self::assertEquals($status->name, $status->forDisplay());
        }
    }

    /**
     * @test
     */
    public function shouldReturnToBePricedWhenForDisplay()
    {
        $active = JobStatus::ToPriced;
        self::assertEquals('To Be Priced', $active->forDisplay());
    }

    public function getJobStatusEnum(): array
    {
        return [JobStatus::cases()];
    }
}
